<?php

namespace App\Http\Controllers\SimCard;

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

class SimCardController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'filters' => 'required|array'
        ]);
        $filters = $request->filters;
        if ($filters['status'] != null && $filters['start_created_date'] == null && $filters['end_created_date'] == null) {
            $simCards = SimCard::where('status', $filters['status'])->get();
            return $simCards;
        } elseif ($filters['status'] != null && $filters['start_created_date'] != null && $filters['end_created_date'] == null) {
            $simCards = SimCard::where('status', $filters['status'])
                ->where('created_at', '>=', $filters['start_created_date'])->get();
            return $simCards;
        } elseif ($filters['status'] == null && $filters['start_created_date'] != null && $filters['end_created_date'] != null) {
            $simCards = SimCard::where('created_at', '>=', $filters['start_created_date'])
                ->where('created_at', '<=', $filters['end_created_at'])->get();
            return $simCards;
        } elseif ($filters['status'] != null && $filters['start_created_date'] != null && $filters['end_created_date'] != null) {
            $simCards = SimCard::where('status', $filters['status'])->where('created_at', '>=', $filters['start_created_date'])->where('created_at', '<=', $filters['end_created_date'])->get();
            return $simCards;
        }

        // $simcards = SimCard::all();
        // return $simcards;
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
            'number' => 'required|string',
            'status' => 'required',
            'user_id' => 'required',
            'days' => 'required',
        ]);
        $data = new CreateSimCardData([
            'number' => $request->number,
            'status' => (int)$request->status,
            'days' => (int)$request->days,
            'user_id' => (int)$request->user_id
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
    public function search(Request $request)
    {
        $validated = $request->validate([
            'keywords' => 'required|string'
        ]);
        $simCards = SimCard::where('number', 'like', '%' . $request->keywords . '%')->get();
        return $simCards;
    }
}
