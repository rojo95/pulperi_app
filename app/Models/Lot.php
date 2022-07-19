<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lot extends Model
{
    use HasFactory;

    protected $fillable = [
        'cod_lot',
        'quantity',
        'expiration',
        'price_bs',
        'price_dollar',
        'sell_price',
        'divisa_id',
        'status',
    ];

    // relacion de lotes asociado a un descuento
    public function LotToDiscount()
    {
        return $this->hasMany(LotToDiscount::class);
    }

    // Relación con su producto
    public function products() {
        return $this->belongsTo(Product::class,'id');
    }
}
