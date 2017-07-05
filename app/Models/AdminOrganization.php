<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminOrganization extends Model
{
    protected $softDelete = true;

    protected $fillable = [
        'id',
        'admin_id',
        'admin_organization_id',
    ];
}