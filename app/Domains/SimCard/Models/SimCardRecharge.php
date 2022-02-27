<?php

namespace App\Domains\SimCard\Models;

use Illuminate\Database\Eloquent\Model;

class SimCardRecharge extends Model
{
    protected $table = 'sim_card_recharges';

    protected $fillable = [
        'iccid',
        'start_date',
        'end_date',
        'available_days',
        'status',
        'email',
        'price',
        'sim_card_id',
        'user_id',
        'payment_intent',
        'payment_intent_client_secret',
    ];

    const STATUS_NEW = 1;
    const STATUS_AWAITING = 2;
    const STATUS_ACTIVATED = 3;

    public function sim_card(){
        return $this->belongsTo(SimCard::class,'sim_card_id');
    }
}
