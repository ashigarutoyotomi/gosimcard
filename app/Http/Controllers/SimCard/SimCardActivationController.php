<?php

namespace App\Http\Controllers\SimCard;

use App\Domains\SimCard\Gateways\SimCardActivationGateway;
use App\Http\Requests\SimCard\SimCardActivation\CreateSimCardActivationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domains\SimCard\Models\SimCard;
use App\Domains\SimCard\Models\SimCardActivation;
use App\Domains\SimCard\Actions\SimCardActivationAction;
use App\Domains\SimCard\DTO\SimCardDTO\CreateSimCardActivationData;

class SimCardActivationController extends Controller
{
    public function index(Request $request)
    {
        $gateway = new SimCardActivationGateway();

        $keywords = $request->get('keywords');
        if ($keywords) {
            $gateway->setSearch($keywords, ['iccid', 'email']);
        }

        $filters = json_decode($request->get('filters'), true);
        if ($filters) {
            $gateway->setFilters($filters);
        }

        $gateway->paginate(20);

        return $gateway->all();
    }

    public function show($simActivationId)
    {
        $simActivation = SimCardActivation::with('sim_card')
            ->find($simActivationId);
        abort_unless((bool)$simActivation, 404, 'activation not found');
        return $simActivation;
    }

    public function store(CreateSimCardActivationRequest $request)
    {
        $simCard = SimCard::where('iccid', $request->iccid)->first();
        abort_unless((bool)$simCard,404,'Sim Card not found');

        $gateway = new SimCardActivationGateway();

        $id = $request->get('id');
        if ($id) {
            $simCardActivation = $gateway->getById($id);
            if ($simCardActivation) {
                return $gateway->getById($id);
            }
        }

        $data = CreateSimCardActivationData::fromRequest($request, $simCard->id);

        $simActivation = (new SimCardActivationAction)->create($data);

        // Mail::to('admin@gmail.com')->send(new SimCardActivationCreated($simActivation));

        return $simActivation;
    }

    public function process(int $id)
    {
        $gateway = new SimCardActivationGateway();

        $simCardActivation = $gateway->getById($id);
        abort_unless((bool)$simCardActivation, 404, 'Sim card activation not found');

        $simCardActivation->status = SimCardActivation::STATUS_AWAITING;
        $simCardActivation->save();

        return $simCardActivation;
    }

    public function activate(int $id)
    {
        $simActivation = SimCardActivation::with('sim_card')->find($id);
        abort_unless((bool)$simActivation, 404, 'sim cart activation not found');

        $simActivation->status = SimCardActivation::STATUS_ACTIVATED;
        $simActivation->save();
        // Mail::to("admin@gmail.com")->send(new SimCardActivated($simActivation));
        return $simActivation;
    }

    public function delete($id)
    {
        $simActivation = SimCardActivation::find($id);
        abort_unless((bool)$simActivation, 404, 'Sim activation not found');
        $simActivation->delete();
        return $simActivation;
    }
}
