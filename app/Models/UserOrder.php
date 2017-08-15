<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOrder extends Model
{
    protected $fillable = [
        'user_id',
        'organization_id',
        'order',
        'status',
        'pay_method',
        'pay_type',
        'delivery_address',
        'take_time',
    ];
    // statuses
    public static $status = array(1 => 'orderStatusSended','orderStatusResend','orderStatusApproved','orderStatusClosed');

    const SENDED = 1;
    const RESEND = 2;
    const APPROVED = 3;
    const CLOSED = 4;

    // pay methods
    const CREDIT = 1;
    const INPLACE = 2;

    // pay types
    const DELIVERY = 1;
    const PHARMACY = 2;

    public function order_details()
    {
        return $this->hasMany('App\Models\UserOrderDetails','user_order_id');
    }
}
