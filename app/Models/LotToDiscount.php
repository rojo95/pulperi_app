<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotToDiscount extends Model
{
    use HasFactory;

    protected $table = 'lot_to_discount';

    protected $fillable = [
        'to_discount_id',
        'lot_id',
        'quantity',
        'price_bs',
        'price_usd',
    ];

    // relación uno a muchos descuento asociado a lote
    public function todiscount()
    {
        return $this->belongsTo(toDiscount::class);
    }

    // relacion de lote asociado al descuento
    public function LotToDiscount()
    {
        return $this->belongsTo(Lot::class,'lot_id');
    }

}
