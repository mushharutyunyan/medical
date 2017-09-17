<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    Const STATUS = array(1 => 'Whole Sale', 'Pharmacy', 'Other Organization');
    Const WHOLESALE = 1;
    Const PHARMACY = 2;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'admin_id', 'director', 'status', 'email', 'city','street', 'apartment','image',
        'identification_number', 'bank_account_number', 'phone'
    ];

    public function admin()
    {
        return $this->hasMany('App\Models\Admin','organization_id');
    }

    public function location()
    {
        return $this->hasMany('App\Models\OrganizationLocation','organization_id');
    }
}
