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
    const ACCEPTINGTO = 3;
    const ACCEPTINGFROM = 4;
    public static $status = ['Saved','Proceed To','Proceed From','Accepting to','Accepting from'];
    protected $fillable = [
        'to',
        'from',
        'file',
        'status'
    ];

    public function organizationTo()
    {
        return $this->belongsTo('App\Models\Organization','to');
    }

    public function organizationFrom()
    {
        return $this->belongsTo('App\Models\Organization', 'from');
    }
}
