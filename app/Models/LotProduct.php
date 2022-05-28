<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LotProduct extends Model
{
    use HasFactory;

    protected $table = 'lot_product';

    protected $fillable = [
        'lot_id',
        'product_id',
        'updated_at',
    ];

}
