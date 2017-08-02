<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialUser extends Model
{
    protected $fillable = [
        'id', 'provider', 'social_id','user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
