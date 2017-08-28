<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderBusy extends Model
{
    protected $fillable = [
        'admin_id',
        'order_id',
        'organization_id',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function admin()
    {
        return $this->belongsTo('App\Models\Admin');
    }
}
