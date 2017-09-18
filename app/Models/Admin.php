<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use SoftDeletes;

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
    protected $softDelete = true;

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }
    public function admin_organizations()
    {
        return $this->hasMany('App\Models\AdminOrganization', 'admin_id');
    }

}
