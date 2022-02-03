<?php

namespace App\Http\Controllers\SimCard;

use Illuminate\Http\Request;
use App\Mail\SimCardActivated;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SimCardActivationCreated;
use App\Domains\SimCard\Models\SimCard;
use App\Domains\SimCard\Models\SimActivation;
use App\Http\Requests\SimCard\SimCardRequest;
use App\Domains\SimCard\Gateways\SimCardGateway;
use App\Domains\SimCard\Actions\SimCardActivationAction;
use App\Domains\SimCard\DTO\SimCardDTO\UpdateSimCardData;
use App\Domains\SimCard\DTO\SimCardDTO\CreateSimCardActivationData;

class SimCardActivationController extends Controller
{
    public function index(Request $request)
    {
        $filters = json_decode($request->get('filters'), true);
        $simActivationsFromSim = [];
        $simActivationsQuery = SimActivation::query();
        $simActivationsQuery->select('sim_activations.*')
            ->distinct();
        if (!empty($request->get('keywords'))) {
            $simActivationsQuery
                ->leftJoin('simcards', 'sim_activations.sim_card_id', '=', 'simcards.id')
                ->where('simcards.number', 'like', '%' . $request->get('keywords') . '%');
        }
        if (!empty($request->get('filters'))) {
            if (!empty($filters['start_created_date'])) {
                $simActivationsQuery->where('sim_activations.created_at', '>=', $filters['sim_activations.start_created_date']);
            }
            if (!empty($filters['end_created_date'])) {
                $simActivationsQuery->where('sim_activations.created_at', '<=', $filters['end_created_date']);
            }
            if (!empty($filters['start_date'])) {
                $simActivationsQuery->where('sim_activations.start_date', $filters['start_date']);
            }
            if (!empty($filters['end_date'])) {
                $simActivationsQuery->where('sim_activations.end_date', $filters['end_date']);
            }
            if (!empty($filters['status'])) {
                $simActivationsQuery->where('sim_activations.status', $filters['status']);
            }
        }

        $simActivationsQuery->with('simcard');

        return response()->json($simActivationsQuery->get());
    }

    public function show($simActivationId)
    {
        $simActivation = SimActivation::with('simcard')
            ->find($simActivationId);
        abort_unless((bool)$simActivation, 404, 'activation not found');
        return $simActivation;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'available_days' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'status' => "nullable|integer",
            'number' => 'required|string',
            'user_id' => 'nullable|integer'
        ]);
        $simCard = SimCard::where('number', $request->number)->first();
        abort_unless((bool)$simCard,404,'simcard not found');
        if ($simCard != null) {
            $request->sim_card_id = $simCard->id;
        }
        $data = new CreateSimCardActivationData([
            'available_days' => (int)$request->available_days,
            'end_date' => $request->end_date,
            'start_date' => $request->start_date,
            'user_id' => $request->user_id,
            'status' => $request->status,
            'number' => $request->number
        ]);

        $simActivation = (new SimCardActivationAction)->create($data);

        // Mail::to('admin@gmail.com')->send(new SimCardActivationCreated($simActivation));

        return $simActivation;
    }
    public function activate(Request $request, $simActivationId)
    {
        $simActivation = SimActivation::with('simcard')->find($simActivationId);
        abort_unless((bool)$simActivation, 404, 'simactivation not found');
        $simCard = $simActivation->simcard;
        $simCard->status = SimCard::STATUS_ACTIVATED;
        $simActivation->status = SimCard::STATUS_ACTIVATED;
        $simCard->save();
        $simActivation->save();
        // Mail::to("admin@gmail.com")->send(new SimCardActivated($simActivation));
        return $simCard;
    }

    public function delete($id)
    {
        $simActivation = SimActivation::find($id);
        abort_unless((bool)$simActivation, 404, 'Sim activation not found');
        $simActivation->delete();
        return $simActivation;
    }
}
