<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Storage extends Model
{
    use SoftDeletes;
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
