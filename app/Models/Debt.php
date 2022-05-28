<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'status'
    ];

    // cliente dueño de la deuda
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // transacciones asociadas a ésta deuda
    public function movements()
    {
        return $this->hasMany(DebtorMovement::class);
    }
}
