<?php

namespace App\Domains\SimCard\Models;

use App\Domains\User\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SimCardActivation extends Model
{
    protected $table = 'sim_card_activations';

    public $fillable = [
        'iccid',
        'available_days',
        'start_date',
        'end_date',
        'email',
        'status',
        'sim_card_id',
        'user_id',
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

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
