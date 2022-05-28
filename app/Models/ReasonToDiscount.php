<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReasonToDiscount extends Model
{
    use HasFactory;

    protected $table = 'reason_to_discount';

    protected $fillable = [
        'reason',
        'to_discount_id'
    ];

}
