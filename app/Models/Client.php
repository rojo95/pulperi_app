<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'ced',
        'address',
        'name',
        'lastname',
        'status',
    ];

    // transacciones realizadas
    public function client()
    {
        return $this->hasMany(Transaction::class);
    }

    // mostrar deudas
    public function debts()
    {
        return $this->hasMany(Debt::class);
    }


}
