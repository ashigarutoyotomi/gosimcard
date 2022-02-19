<?php

namespace App\Domains\SimCard\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SimCard extends Model
{
    protected $table = 'sim_cards';

    protected $fillable = [
        'iccid',
        'valid_days',
        'expiration_days',
        'creator_id',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function activations(): HasMany
    {
        return $this->hasMany(SimCardActivation::class,'sim_card_id');
    }

    public function recharges(): HasMany
    {
        return $this->hasMany(SimRecharge::class,'sim_card_id');
    }
}
