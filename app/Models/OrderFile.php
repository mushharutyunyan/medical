<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class OrderFile extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'order_id',
        'organization_id',
        'file'
    ];
}
