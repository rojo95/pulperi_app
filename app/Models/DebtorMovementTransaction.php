<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebtorMovementTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'debtor_movement_id',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function DebtorMovement()
    {
        return $this->belongsTo(DebtorMovement::class);

    }
}
