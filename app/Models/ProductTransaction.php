<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'transaction_id',
        'quantity',
        'price_usd',
        'price_bs',
    ];

    // producto por transaccion
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
