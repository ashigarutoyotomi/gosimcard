<?php

namespace App\Http\Controllers\SimCard;
use Spp\Http\Requests\SimCard\SimCardRequest;
use App\Http\Controllers\Controller;
use App\Domains\SimCards\Gateways\SimCardGateway;
use App\Http\Requests\SimCard\SimCardRequest;

class SimCardController extends Controller
{
    public function index()
    {
        $gateway = new SimCardGateway();
        $gateway->paginate(20);
        return $gateway->all();
    }
    public function show($simCardId){
        $gateway = new SimCardGateway();
        return $gateway->getById($simCardId);
    }
    public function edit($simCardId){
        $gateway = new SimCardGateway();
        return $gateway->getById($simCardId);
    }
    public function store(SimCardRequest $request){
        // $data = CreateSimCardData::from
    }
    public function update($simCardId,SimCardRequest $request){

    }
    public function delete ($simCardId){
        return (new SimCardAction)->delete($simCardId);
    }
}
