<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Order extends Model
{
    use SoftDeletes;
    const SAVED = 0;
    const PROCEEDTO = 1;
    const PROCEEDFROM = 2;
    const APPROVED = 3;
    const CANCELED = 4;
    const RECEIVED = 5;
    public static $status = ['Saved','Proceed To','Proceed From','Approved','Canceled','Received'];
    protected $fillable = [
        'to',
        'from',
        'status',
        'delivery_status_id',
        'file',
        'date',
        'delivery_address',
        'delivery_date',
        'discount'
    ];

    public function organizationTo()
    {
        return $this->belongsTo('App\Models\Organization','to');
    }

    public function organizationFrom()
    {
        return $this->belongsTo('App\Models\Organization', 'from');
    }

    public function delivery_status()
    {
        return $this->belongsTo('App\Models\OrderDeliveryStatus');
    }

    public function orderInfo()
    {
        return $this->hasMany('App\Models\OrderInfo','order_id');
    }

    public function messages()
    {
        return $this->hasMany('App\Models\OrderMessage','order_id');
    }

}
