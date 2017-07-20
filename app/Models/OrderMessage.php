<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class OrderMessage extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'order_id',
        'from',
        'message'
    ];

    public function organizationTo()
    {
        return $this->belongsTo('App\Models\Organization','to');
    }
}
