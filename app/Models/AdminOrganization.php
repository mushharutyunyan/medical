<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminOrganization extends Model
{
    protected $softDelete = true;

    protected $fillable = [
        'id',
        'admin_id',
        'organization_id',
    ];

    public function admin()
    {
        return $this->hasMany('App\Models\Admin', 'organization_id','organization_id');
    }
    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }
}
