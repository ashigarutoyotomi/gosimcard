<?php

namespace App\Http\Controllers\SimCard;
use App\Http\Requests\SimCard\CreateSimCardRequest;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Domains\SimCard\Gateways\SimCardGateway;
use App\Http\Requests\SimCard\SimCardRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Domains\SimCard\DTO\SimCardDTO\CreateSimCardData;
use App\Domains\SimCard\DTO\SimCardDTO\UpdateSimCardData;
use App\Domains\SimCard\Actions\SimCardAction;
use App\Domains\SimCard\Models\SimCard;
use App\Models\User;

class SimCardController extends Controller
{
    public function index(Request $request)
    {
        $gateway = new SimCardGateway();

        $keywords = $request->get('keywords');
        if ($keywords) {
            $gateway->setSearch($keywords, ['iccid']);
        }

        $filters = json_decode($request->get('filters'), true);
        if ($filters) {
            $gateway->setFilters($filters);
        }

        $gateway->paginate(20);

        return $gateway->all();
    }

    public function show(int $simCardId)
    {
        $simCard = SimCard::find($simCardId);
        abort_unless((bool)$simCard, 404, 'simcard not found');

        $gateway = new SimCardGateway();
        $gateway->with('creator');

        return $gateway->getById($simCardId);
    }

    public function checkByIccid(string $iccid)
    {
        $gateway = new SimCardGateway();
        $simCard = $gateway->getByIccid($iccid);
        abort_unless((bool)$simCard, 404, 'Sim card with this ICCID not found');

        return [
            'iccid' => $simCard->iccid,
            'valid_days' => $simCard->valid_days,
            'expiration_days' => $simCard->expiration_days,
        ];
    }

    public function store(CreateSimCardRequest $request)
    {
        $data = CreateSimCardData::fromRequest($request);

        return (new SimCardAction)->create($data);
    }

    public function delete(int $simCardId)
    {
        $simCard = SimCard::find($simCardId);
        abort_unless((bool)$simCard, 404, 'sim card not found');

        $simCard->delete();
        $activations = $simCard->activations;

        foreach ($activations as $activation) {
            $activation->delete();
        }

        return $simCard;
    }

    public function createFromCsv(Request $request){
        $validated = $request->validate([
            'csv' => 'required|file'
        ]);

        if($request->file('csv')->getClientOriginalExtension()!= 'csv'){
            abort(403, 'File must be in csv format');
        }

        $user = Auth::user();

        if ($request->file('csv')->isValid()){
            $simCardsFromFile = [];
            $simCardNumbersFromFile = [];
            $newSimCards = [];

            $path = $request->csv->storeAs('csv', md5(time()).'.csv');

            $handle = fopen(base_path('storage/app/'.$path),'r');

            $i = 0;
            while ((($row = fgetcsv($handle)) !== FALSE)) {
                if ($i === 0) {
                    $i++;
                    continue;
                }

                $simCardsFromFile[] = $row;
                $simCardNumbersFromFile[] = $row[0];
                $i++;
            }

            fclose($handle);

            $simCards = SimCard::whereIn('iccid', $simCardNumbersFromFile)->get();
            $simCardNumbers = $simCards->pluck('iccid')->toArray();

            foreach ($simCardsFromFile as $simCardFromFile) {
                if (in_array($simCardFromFile[0], $simCardNumbers, true)) {
                    continue;
                }

                $data = new CreateSimCardData([
                    'iccid' => $simCardFromFile[0],
                    'valid_days' => (int)$simCardFromFile[1],
                    'expiration_days' => (int)$simCardFromFile[2],
                    'creator_id' => $user->id,
                ]);

                $newSimCards[] = (new SimCardAction)->create($data);
            }
        }

        return $newSimCards;
    }
}
