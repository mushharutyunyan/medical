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
    public static $status = array(
        1 => 'orderStatusSended',
        'orderStatusResend',
        'orderStatusApproved',
        'orderStatusClosed',
        'orderStatusCanceled',
        'orderStatusApprovedByPharmacy',
        'orderStatusChangedByPharmacy',
        'orderStatusApprovedByUser',
        'orderStatusCanceledByUser',
        'orderStatusDelivered',
    );

    const SENDED = 1;
    const RESEND = 2;
    const APPROVED = 3;
    const CLOSED = 4;
    const CANCELED = 5;
    const APPROVEDBYPHARMACY = 6;
    const CHANGEDBYPHARMACY = 7;
    const APPROVEDBYUSER = 8;
    const CANCELEDBYUSER = 9;
    const DELIVERED = 10;

    // pay methods
    public static $pay_methods = array(1 => 'Credit','In place');
    const CREDIT = 1;
    const INPLACE = 2;

    // pay types
    public static $pay_types = array(1 => 'Delivery','Take in pharmacy');
    const DELIVERY = 1;
    const PHARMACY = 2;

    public function order_details()
    {
        return $this->hasMany('App\Models\UserOrderDetails','user_order_id');
    }

    public function order_messages()
    {
        return $this->hasMany('App\Models\UserOrderMessage','user_order_id');
    }

    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }

}
