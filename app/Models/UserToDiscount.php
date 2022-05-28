<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserToDiscount extends Model
{
    use HasFactory;

    protected $table = 'user_to_discount';

    protected $fillable = [
        'user_id',
        'to_discount_id'
    ];

    public function user_discount() {
        return $this->hasOne(User::class);
    }

    public function discount_user() {
        return $this->hasOne(toDiscount::class);
    }


}
