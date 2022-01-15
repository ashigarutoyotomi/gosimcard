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
use App\Mail\SimRechargeCreated;

class SimCardRechargeController extends Controller{
    public function index(){
        $simRecharges = SimRecharge::all();
        return $simRecharges;
    }
    public function store(Request $request){
        // $validated = $request->validate([
        //     'days'=> 'required|integer',
        //     'sim_card_id'=>'required|integer',
        //     'user_id'=>'required|integer',
        //     'status'=>"nullable|integer",
        //     'number'=>'required|string',
        //     'email'=>'nullable|string'
        // ]);    
        $data = new CreateSimCardRechargeData([
            'days'=>(int)$request->days,
            'number'=>(string)$request->number,
            'sim_card_id'=>(int)$request->sim_card_id,
            'user_id'=>(int)$request->user_id,
            'status'=>SimCard::STATUS_NEW
        ]);
        $simRecharge = (new SimCardRechargeAction)->create($data);
        if($request->email!=null&&!empty($request->email)){
            $simCard = SimCard::find($request->sim_card_id, $simRecharge);
            $user = $simCard->user;
            $simRechargeCreated = new SimRechargeCreated($simRecharge,$user);
            Mail::to('admin@gmail.com')->send($simRechargeCreated);
        }
        return $simRecharge;
    }
    public function show($simRechargeId){
        $simRecharge = SimRecharge::find($simRechargeId);
        return $simRecharge;
    }
    public function recharge(SimCardRechargeRequest $request,$simRechargeId){
        $simRechargeData = UpdateSimCardRechargeData::fromRequest($simRechargeId, $request);
        // $simRecharge = SimRecharge::find($simRechargeId);
        // $simRecharge = SimRecharge::find($simRechargeId);
        $simRecharge = new SimCardRechargeAction();
        abort_unless((bool)$simRecharge,404,'not found');
        // $simRecharge->days = $request->days;
        // $simRecharge->status = SimCard::STATUS_ACTIVATED;
        // $simRecharge->save();        
        $simRecharge = $simRecharge->update($simRechargeData,$simRecharge);
        return $simRecharge;
    }
}