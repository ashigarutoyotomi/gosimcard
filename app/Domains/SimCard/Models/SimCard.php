<?php

namespace App\Domains\SimCards\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimCard extends Model
{
    use HasFactory;
    protected $table = 'simcards';

    protected $fillable = [
        'name', 'quantity', 'image_src',
    ];
}
