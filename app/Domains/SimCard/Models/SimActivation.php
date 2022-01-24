<?php

namespace App\Domains\SimCard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domains\SimCard\Models\SimCard;

class SimActivation extends Model
{
    use HasFactory;

    const STATUS_NEW = 1;
    const STATUS_IN_PROCESS = 2;
    const STATUS_ACTIVATED = 3;

    public $fillable = [
        'available_days', 'start_date', 'end_date', 'status', 'sim_card_id', 'user_id'
    ];

    public function simcard()
    {
        return $this->belongsTo(SimCard::class, 'sim_card_id');
    }
}
