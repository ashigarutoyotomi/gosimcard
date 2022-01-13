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
        $simActivation = new SimActivation();
        $validated = $request->validate([
            'available_days'=> 'required|integer',
            'start_date'=>'required|date',
            'end_date'=>'required|date',
            'status'=>"nullable|integer",
        ]);
abort_unless((bool)$simActivation,404,'simcard not found');
        $simActivation->start_date= $request->start_date;
        $simActivation->end_date = $request->end_date;
        $simActivation->status = $request->status;        
        $simActivation->available_days = $request->days;   
        $simActivation->save();
        Mail::to('admin@gmail.com')->send(new SimCardActivationCreated($simActivation));
        return $simActivation;
    }
    public function activate(Request $request ,$simActivationId){
        $simActivation = SimActivation::find($simActivationId);
        abort_unless((bool)$simActivation,404,'simactivation not found');
        $simActivation->status = SimCard::STATUS_ACTIVATED;
        $simCard = $simActivation->simcard;
        $simCard->status = SimCard::STATUS_ACTIVATED;
        $simCard->save();
        $simActivation->save();
        Mail::to("admin@gmail.com")->send(new SimCardActivated($simActivation));
    }
}