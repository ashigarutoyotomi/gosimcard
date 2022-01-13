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
    public function index()
    {
        $simcards = SimCard::all();
        return $simcards;
    }
    public function show($simCardId){
        $simcard = SimCard::find($simCardId);
        abort_unless((bool)$simcard,404,'simcard not found');        
        return $simcard;
    }
    public function store(Request $request){
        $validated = $request->validate([
            'number'=>'required|string',
            'status'=>'required',
            'user_id'=>'required',
            'days'=>'required',
        ]);
        $data = new CreateSimCardData(['number'=>$request->number,
        'status'=>(int)$request->status,
        'days'=>(int)$request->days,
        'user_id'=>(int)$request->user_id
        ]);
        $simcard = (new SimCardAction)->create($data);
        return $simcard;
    }
    public function delete ($simCardId){
        $simcard = SimCard::find($simCardId);
        $simcard->delete();
        abort_unless((bool)$simcard,404,'simcard not found');
        return $simcard;
    }
}
