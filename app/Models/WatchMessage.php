<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WatchMessage extends Model
{
    protected $fillable = [
        'admin_id',
        'partner_id',
    ];
}
