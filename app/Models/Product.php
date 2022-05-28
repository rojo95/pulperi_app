<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'img',
        'description',
        'bar_code',
        'unit_box',
        'sales_measure_id',
        'products_type_id',
    ];

    // Relación muchos a muchos con los productos
    public function product(){
        return $this->hasMany(Lot::class,'id');
    }

    // Relación muchos a uno de typo de producto a productos
    public function type(){
        return $this->belongsTo(ProductsType::class,'products_type_id','id');
    }

    // Relación muchos a muchos con los lotes
    public function lots() {
        return $this->belongsToMany(Lot::class);
    }

    public function product_lot()
    {
        return $this->hasMany(LotProduct::class);
    }
}
