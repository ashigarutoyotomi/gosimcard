<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Domains\SimCard\Models\SimCard;
class SimActivation extends Model
{
    use HasFactory;
    public function simcard(){
        return $this->belongsTo(SimCard::class);
    }
}
