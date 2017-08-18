<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class OrderInfo extends AbstractModel
{
    use SoftDeletes;
    protected $fillable = [
        'order_id',
        'storage_id',
        'count'
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function storage()
    {
        return $this->belongsTo('App\Models\Storage');
    }


}
