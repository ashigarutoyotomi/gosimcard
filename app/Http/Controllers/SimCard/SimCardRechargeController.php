<?php

namespace App\Http\Controllers\SimCard;

use App\Http\Controllers\Controller;
use App\Domains\SimCard\Gateways\SimCardRechargeGateway;
use App\Http\Requests\SimCard\SimCardRechargeRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Domains\SimCard\DTO\SimCardDTO\CreateSimCardRechargeData;
use App\Domains\SimCard\DTO\SimCardDTO\UpdateSimCardRechargeData;
use App\Domains\SimCard\Actions\SimCardRechargeAction;
use App\Domains\SimCard\Models\SimActivation;
use App\Domains\SimCard\Models\SimRecharge;
use Illuminate\Support\Facades\Mail;
use App\Domains\SimCard\Models\SimCard;
use App\Mail\SimRecharged;

class SimCardRechargeController extends Controller
{
    public function index()
    {
        $simRecharges = SimRecharge::all();
        return $simRecharges;
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'days' => 'required|integer',
            'user_id' => 'nullable|integer',
            'status' => "nullable|integer",
            'number' => 'required|string',
            'email' => 'nullable|string'
        ]);

        $simCard = SimCard::where('number', $request->number)->first();
        abort_unless((bool)$simCard, 404, 'simcard with this number not found');
        $sim_card_id = $simCard->id;

        $data = new CreateSimCardRechargeData([
            'days' => (int)$request->days,
            'number' => $request->number,
            'sim_card_id' => $sim_card_id,
            'user_id' => (int)$request->user_id,
            'status' => !empty($request->status) ? (int)$request->status : null,
            'email' => $request->email
        ]);
        $simRecharge = (new SimCardRechargeAction)->create($data);
        return $simRecharge;
    }
    public function show($simRechargeId)
    {
        $simRecharge = SimRecharge::find($simRechargeId);
        return $simRecharge;
    }
    public function recharge(SimCardRechargeRequest $request, $simRechargeId)
    {
        $simRechargeData = UpdateSimCardRechargeData::fromRequest($simRechargeId, $request);
        $simRecharge = new SimCardRechargeAction();
        $isEmailUnique = SimRecharge::where('email', $request->email)->get();
        if (count(($isEmailUnique->modelKeys())) != 1) {
            abort(403, 'email already exists');
        }
        abort_unless((bool)$simRecharge, 404, 'not found');
        $simRecharge = $simRecharge->update($simRechargeData, $simRecharge);
        if ($request->email != null && !empty($request->email)) {
            $simCard = Simcard::find($request->sim_card_id, $simRecharge);
            $user = $simCard->user;
            $simRecharged = new SimRecharged($simRecharge, $user);
            Mail::to($request->email)->send($simRecharged);
        }
        return $simRecharge;
    }
}
