<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethodDebtorMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_method_id',
        'debtor_movement_id'
    ];
}
