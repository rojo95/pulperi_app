<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class toDiscount extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_to_discount_id',
        'user_id',
        'status',
    ];

    // Relación uno a muchos de tipo de descuento a productos descontados
    public function type(){
        return $this->hasOne(TypeToDiscount::class,'id','type_to_discount_id');
    }

    // Relación de muchos a uno de usuario que registró el retiro
    public function discounter() {
        return $this->belongsTo(User::class,'user_id');
    }

    // relacion un descuento asociado a varios lotes
    public function todiscount()
    {
        return $this->hasMany(LotToDiscount::class);
    }

    public function reason()
    {
        return $this->hasOne(ReasonToDiscount::class);
    }


}
