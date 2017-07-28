<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'to',
        'from',
        'message',
    ];
    public function adminTo()
    {
        return $this->belongsTo('App\Models\Admin','to');
    }

    public function adminFrom()
    {
        return $this->belongsTo('App\Models\Admin', 'from');
    }
}
