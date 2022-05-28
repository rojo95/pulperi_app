<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeToDiscount extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'status',
    ];

    // Relación muchos a uno de descuentos
    public function type(){
        return $this->belongsTo(ToDiscount::class);
    }

}
