<?php

namespace App\Domains\SimCard\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domains\SimCard\Models\SimActivation;
use App\Domains\SimCard\Models\SimRecharge;

class SimCard extends Model
{
    use HasFactory;

    protected $table = 'simcards';

    protected $fillable = [
        'number',
        'user_id',
        'days',
        'status'
    ];

    const STATUS_NEW = 1;
    const STATUS_IN_PROCESS = 2;
    const STATUS_ACTIVATED = 3;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function activations(){
        return $this->hasMany(SimActivation::class,'sim_card_id');
    }

    public function recharges (){
        return $this->hasMany(SimRecharge::class,'sim_card_id');
    }
}
