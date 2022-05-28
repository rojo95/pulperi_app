<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_type',
        'client_id',
        'user_id',
        'status'
    ];

    // vendedor de la transaccion
    public function seller()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    // cliente de la transacción
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // productos de la transacción
    public function products()
    {
        return $this->hasMany(ProductTransaction::class);
    }

    // metodos de pago
    public function method()
    {
        return $this->belongsToMany(PaymentMethod::class,'payment_method_transactions');
    }

    // deuda asociada
    public function debtMovement()
    {
        return $this->hasOne(DebtorMovementTransaction::class);
    }
}
