<?php

namespace App\Http\Controllers\SimCard;

use App\Domains\SimCard\DTO\SimCardDTO\RechargeSimCardRechargeData;
use App\Domains\SimCard\Gateways\SimCardRechargeGateway;
use App\Domains\SimCard\Models\SimCardRecharge;
use App\Http\Controllers\Controller;
use App\Domains\SimCard\DTO\SimCardDTO\CreateSimCardRechargeData;
use App\Domains\SimCard\DTO\SimCardDTO\UpdateSimCardRechargeData;
use App\Domains\SimCard\Actions\SimCardRechargeAction;
use App\Domains\SimCard\Models\SimRecharge;
use App\Domains\SimCard\Models\SimCard;
use App\Http\Requests\SimCard\SimCardRecharge\RechargeSimCardRechargeRequest;
use App\Http\Requests\SimCard\SimCardRecharge\SimCardRechargeRequest;
use App\Mail\SimRecharged;
use Illuminate\Http\Request;

class SimCardRechargeController extends Controller
{
    public function index(Request $request)
    {
        $gateway = new SimCardRechargeGateway();

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

    public function show($simRechargeId)
    {
        return SimCardRecharge::find($simRechargeId);
    }

    public function store(SimCardRechargeRequest $request)
    {
        $simCard = SimCard::where('iccid', $request->iccid)->first();
        abort_unless((bool)$simCard, 404, 'Sim card with this iccid not found');

        $id = $request->get('id');
        if ($id) {
            $simCardRecharge = SimCardRecharge::find($id);
            if ($simCardRecharge) {
                return $simCardRecharge;
            }
        }

        $data = CreateSimCardRechargeData::fromRequest($request, $simCard->id);

        return (new SimCardRechargeAction)->create($data);
    }

    public function payment()
    {
        \Stripe\Stripe::setApiKey('sk_test_51IV8PJCrmyCPrP33RmtwD6RqY6Nic3M5F7DCuszPqMGTQJtxpEVGdPhB0aFwePVGr2HreEZBKCqiHfkEFFQZrGQM00lQc0uuLN');

        $paymentIntent = \Stripe\PaymentIntent::create([
            'amount' => 2000,
            'currency' => 'usd',
            'automatic_payment_methods' => [
                'enabled' => true,
            ],
        ]);

        return [
            'clientSecret' => $paymentIntent->client_secret,
        ];
    }

    public function recharge(RechargeSimCardRechargeRequest $request, int $simRechargeId)
    {
        $simRechargeData = RechargeSimCardRechargeData::fromRequest($request, $simRechargeId);

        return (new SimCardRechargeAction)->recharge($simRechargeData);
    }

    public function delete($id)
    {
        $data = SimCardRecharge::find($id);
        abort_unless((bool)$data, 404, 'Sim activation not found');
        $data->delete();
        return $data;
    }
}
