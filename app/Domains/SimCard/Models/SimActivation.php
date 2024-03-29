<?php

namespace App\Domains\SimCard\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domains\SimCard\Models\SimCard;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SimActivation extends Model
{
    public $fillable = [
        'available_days',
        'start_date',
        'end_date',
        'status',
        'sim_card_id',
        'email',
        'user_id',
        'sim_number',
    ];

    const STATUS_NEW = 1;
    const STATUS_AWAITING = 2;
    const STATUS_ACTIVATED = 3;

    /**
     * @return BelongsTo
     */
    public function sim_card(): BelongsTo
    {
        return $this->belongsTo(SimCard::class, 'sim_card_id');
    }
}
