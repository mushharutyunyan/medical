<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'to',
        'from',
        'file',
        'status'
    ];

    public function to()
    {
        return $this->belongsTo('App\Models\Organization','to', 'id');
    }

    public function from()
    {
        return $this->belongsTo('App\Models\Organization','from', 'id');
    }
}
