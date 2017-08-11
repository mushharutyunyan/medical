<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOrderMessage extends Model
{
    protected $fillable = [
        'user_order_id',
        'from',
        'message'
    ];
}
