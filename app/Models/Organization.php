<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    Const STATUS = array('Whole Sale', 'Pharmacy', 'Other Organization');
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'admin_id', 'director', 'status', 'email', 'city', 'apartment','image'
    ];

    public function admin()
    {
        return $this->hasMany('App\Models\Admin','organization_id');
    }
}
