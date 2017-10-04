<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class UserOrderDetails extends Model
{
    protected $fillable = [
        'user_order_id',
        'storage_id',
        'price',
        'count'
    ];

    public function storage()
    {
        return $this->belongsTo('App\Models\Storage');
    }
    public function user_order()
    {
        return $this->belongsTo('App\Models\UserOrder');
    }

}
