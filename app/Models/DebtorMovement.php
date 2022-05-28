<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebtorMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'debt_id',
        'movement_type',
        'amount_bs',
        'amount_usd',
        'status'
    ];

    public function transaction()
    {
        return $this->hasOne(DebtorMovementTransaction::class);
    }
    // relacion con la deuda
    public function debt()
    {
        return $this->belongsTo(Debt::class);
    }
    // relacion con metodos de pago
    public function paymentMethods()
    {
        return $this->belongsToMany(PaymentMethod::class,'payment_method_debtor_movements');
    }
}
