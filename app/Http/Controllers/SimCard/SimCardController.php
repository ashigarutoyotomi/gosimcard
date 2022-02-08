<?php

namespace App\Http\Controllers\SimCard;
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
        $filters = json_decode($request->get('filters'));
        $simCardsQuery = SimCard::query();
        if (!empty($request->get('keywords'))) {
            $simCardsQuery->where('number', 'like', '%' . $request->get('keywords') . '%');
        }
        if (!empty($request->get('filters'))) {
            if (!empty($filters['status'])) {
                $simCardsQuery->where('status', $filters['status']);
            }
            if (!empty($filters['start_created_date'])) {
                $simCardsQuery->where('created_at', '>=', $filters['start_created_at']);
            }
            if (!empty($filters['end_created_date'])) {
                $simCardsQuery->where('created_at', '<', $filters['end_created_'], '<=', $filters['end_created_date']);
            }
        }
        $simCards = $simCardsQuery->get();
        return $simCards;
    }

    public function show($simCardId)
    {
        $simcard = SimCard::find($simCardId);
        abort_unless((bool)$simcard, 404, 'simcard not found');
        return $simcard;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'status' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'days' => 'nullable|integer',
            'number' => 'required|string|unique:simcards'
        ]);
        if (!empty($request->user_id)) {
            $user = User::find($request->user_id);
            abort_unless((bool)$user, 404, 'user not found');
        }
        $data = new CreateSimCardData([
            'number' => $request->number,
            'status' => $request->status,
            'days' => (int)$request->days,
            'user_id' => $request->user_id
        ]);

        $simcard = (new SimCardAction)->create($data);

        return $simcard;
    }

    public function delete($simCardId)
    {
        $simcard = SimCard::find($simCardId);
        abort_unless((bool)$simcard, 404, 'simcard not found');
        $simcard->delete();
        $activations = $simcard->activations;
        foreach ($activations as $activation) {
            $activation->delete();
        }
        return $simcard;
    }

    public function createFromCsv(Request $request){
        $validated = $request->validate([
            'csv' => 'required|file'
        ]);

        if($request->file('csv')->getClientOriginalExtension()!= 'csv'){
            abort(403, 'file must be in csv format');
        }

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

            $simCards = SimCard::whereIn('number', $simCardNumbersFromFile)->get();
            $simCardNumbers = $simCards->pluck('number')->toArray();

            foreach ($simCardsFromFile as $simCardFromFile) {
                if (in_array($simCardFromFile[0], $simCardNumbers, true)) {
                    continue;
                }

                $data = new CreateSimCardData([
                    'number' => $simCardFromFile[0],
                    'days' => (int)$simCardFromFile[1],
                    'available_days'=>(int)$simCardFromFile[2],
                    'status' => SimCard::STATUS_NEW,
                ]);

                $newSimCards[] = (new SimCardAction)->create($data);
            }
        }

        return $newSimCards;
    }
}
