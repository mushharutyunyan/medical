<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOrderBusy extends Model
{
    protected $fillable = [
        'admin_id',
        'user_order_id',
        'organization_id',
        'status'
    ];
}
