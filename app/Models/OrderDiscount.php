<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDiscount extends Model
{
    protected $fillable = [
        'whole_sale',
        'pharmacy',
        'discount'
    ];
}
