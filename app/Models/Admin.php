<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'role_id', 'organization_id', 'email' , 'password', 'firstname', 'lastname'
    ];

    protected $hidden = [
        'password',
    ];

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }
}
