<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationLocation extends Model
{
    protected $fillable = [
        'id', 'organization_id', 'latitude', 'longitude'
    ];

    public function organization()
    {
        return $this->belongsTo('App\Models\Organization');
    }
}
