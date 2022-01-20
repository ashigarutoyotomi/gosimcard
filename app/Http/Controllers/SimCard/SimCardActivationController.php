<?php

namespace App\Http\Controllers\SimCard;

use App\Http\Controllers\Controller;
use App\Domains\SimCard\Gateways\SimCardGateway;
use App\Http\Requests\SimCard\SimCardRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Domains\SimCard\DTO\SimCardDTO\CreateSimCardActivationData;
use App\Domains\SimCard\DTO\SimCardDTO\UpdateSimCardData;
use App\Domains\SimCard\Actions\SimCardActivationAction;
use App\Domains\SimCard\Models\SimActivation;
use App\Domains\SimCard\Models\SimCard;
use Illuminate\Support\Facades\Mail;
use App\Mail\SimCardActivationCreated;
use App\Mail\SimCardActivated;

class SimCardActivationController extends Controller
{
    public function index(Request $request)
    {
        $filters = json_decode($request->get('filters'));
        $simActivationsQuery = SimActivation::query();
        if ($request->get('keywords') && !($request->get('filters'))) {
            $simActivations = [];
            $simCards = SimCard::where('number', 'like', '%' . $request->get('keywords') . '%')->get();
            foreach ($simCards as $simCard) {
                $simActivations[] = $simCard->activations;
            }
            return $simActivations;
        } elseif (!($request->get('keywords')) && $request->get('filters')) {
            if ($filters['start_created_date']) {
                $simActivationsQuery->where('created_at', '>=', $filters('start_created_date'));
            }
            if ($filters['end_created_date']) {
                $simActivationsQuery->where('created_at', '<=', $filters['end_created_date']);
            }
            if ($filters['start_date']) {
                $simActivationsQuery->where('start_date', $filters['start_date']);
            }
            if ($filters['end_date']) {
                $simActivationsQuery->where('end_date', $filters['end_date']);
            }
            if ($filters['status']) {
                $simActivationsQuery->where('status', $filters['status']);
            }
        } elseif ($request->get('keywords') && $request->get('filters')) {
            if ($filters['start_created_date']) {
                $simActivationsQuery->where('created_at', '>=', $filters('start_created_date'));
            }
            if ($filters['end_created_date']) {
                $simActivationsQuery->where('created_at', '<=', $filters['end_created_date']);
            }
            if ($filters['start_date']) {
                $simActivationsQuery->where('start_date', $filters['start_date']);
            }
            if ($filters['end_date']) {
                $simActivationsQuery->where('end_date', $filters['end_date']);
            }
            if ($filters['status']) {
                $simActivationsQuery->where('status', $filters['status']);
            }
            $simActivations = [];
            $simCards = SimCard::where('number', 'like', '%' . $request->get('keywords') . '%')->get();
            foreach ($simCards as $simCard) {
                $simActivations[] = $simCard->activations;
            }
            return $simActivations;
        } else {
            $simActivations = SimActivation::all();
            return $simActivations;
        }
        return $simActivationsQuery->get();
    }
    public function show($simActivationId)
    {
        $simActivation = SimActivation::find($simActivationId);
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
            'sim_card_id' => 'required|integer'
        ]);
        $data = new CreateSimCardActivationData([
            'available_days' => (int)$request->available_days,
            'end_date' => (int)$request->end_date,
            'start_date' => (int)$request->start_date,
            'user_id' => (int)$request->user_id,
            'sim_card_id' => (int)$request->sim_card_id,
            'status' => SimCard::STATUS_NEW
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
    public function search(Request $request)
    {
        $keywords = $request->keywords;
        $simCards = SimCard::where('number', 'like', '%' . $keywords . '%')->get();
        $simActivations = [];
        foreach ($simCards as $simCard) {
            $simActivations[] = $simCard->activations;
        }
        return $simActivations;
    }
}
