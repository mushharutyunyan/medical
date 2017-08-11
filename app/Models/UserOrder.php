<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model
{
    protected $fillable = [
        'user_id',
        'organization_id',
        'order',
        'status'
    ];

    public static $status = array(1 => 'orderStatusSended','orderStatusResend','orderStatusApproved','orderStatusClosed');

    const SENDED = 1;
    const RESEND = 2;
    const APPROVED = 3;
    const CLOSED = 4;

    public function order_details()
    {
        return $this->hasMany('App\Models\UserOrderDetails','user_order_id');
    }
}
