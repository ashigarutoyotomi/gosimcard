<?php

namespace App\Domains\SimCard\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simcard extends Model
{
    use HasFactory;
    protected $table = 'simcards';

    protected $fillable = [
        'number', 'user_id', 'days','status'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    const STATUS_NEW = 1, STATUS_IN_PROCESS = 2, STATUS_ACTIVATED =3;
}
