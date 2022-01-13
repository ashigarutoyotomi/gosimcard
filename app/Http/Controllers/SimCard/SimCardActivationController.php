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
use App\Domains\SimCard\Models\SimActivation;
use App\Domains\SimCard\Models\SimCard;
use Illuminate\Support\Facades\Mail;
use App\Mail\SimCardActivationCreated;
use App\Mail\SimCardActivated;
class SimCardActivationController extends Controller{
    public function index(){
        $simActivations = SimActivation::all();
        return $simActivations;
    }
    public function show($simActivationId){
        $simActivation = SimActivation::find($simActivationId);
        return $simActivation;
    }
    public function store(Request $request){
        $simActivation = new SimActivation;
        $validated = $request->validate([
            'available_days'=> 'required|integer',
            'start_date'=>'required|date',
            'end_date'=>'required|date',
            'status'=>"nullable|integer",
            'sim_card_id'=>'required|integer'
        ]);
        $simActivations = [
            'start_date' => $request->start_date,
            'end_date'=>$request->end_date,
            'sim_card_id'=>$request->sim_card_id,
            'status'=>$request->status,
            'available_days'=>$request->available_days,
            'sim_card_id'=>$request->sim_card_id,
            'user_id'=>$request->user_id
            ];
        $simActivation = new SimActivation;
        $simActivation->sim_card_id = $simActivations['sim_card_id'];
        $simActivation->user_id = $simActivations['user_id'];
        $simActivation->start_date= $simActivations['start_date'];
        $simActivation->end_date = $simActivations['end_date'];
        $simActivation->status = $simActivations['status']?$simActivations['status']:1;        
        $simActivation->available_days = $simActivations['available_days'];   
        $simActivation->save();
        // Mail::to('admin@gmail.com')->send(new SimCardActivationCreated($simActivation));
        return $simActivation;
    }
    public function activate(Request $request ,$simActivationId){
        $simActivation = SimActivation::with('simcard')->find($simActivationId);
        abort_unless((bool)$simActivation,404,'simactivation not found');
        $simCard = $simActivation->simcard;
        $simCard->status = 3;
        $simActivation->status =3;               
        $simCard->save();
        $simActivation->save();
        // Mail::to("admin@gmail.com")->send(new SimCardActivated($simActivation));
        return $simCard;
    }
}