<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lastname',
        'identification',
        'genere_id',
        'user_id',
    ];

    // Relación uno a uno
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function userDiscounter()
    {
        return $this->belongsTo(toDiscount::class,'users_id','users_id');
    }

    public function genere(){
        return $this->hasOne(Genere::class,'id','genere_id');
    }
}
