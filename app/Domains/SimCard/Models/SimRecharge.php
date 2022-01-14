<?php

namespace App\Domains\SimCard\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domains\SimCard\Models\Simcard;
class SimRecharge extends Model
{
    use HasFactory;
    protected $table = 'sim_recharges';

    protected $fillable = [
        'sim_number', 'sim_card_id', 'days','status',
        'email'
    ];
    public function simcard(){
        return $this->belongsTo(Simcard::class);
    }
}
