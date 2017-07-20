<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class OrderInfo extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'order_id',
        'drug_id',
        'drug_settings',
        'count'
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function drug()
    {
        return $this->belongsTo('App\Models\Drug');
    }
}
