<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $fillable = [
        'drug_id',
        'organization_id',
        'drug_settings',
        'count'
    ];

    public function drug()
    {
        return $this->belongsTo('App\Models\Drug');
    }
}
