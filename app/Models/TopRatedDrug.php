<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TopRatedDrug extends Model
{
    protected $fillable = [
        'storage_id'
    ];

    public function storage()
    {
        return $this->belongsTo('App\Models\Storage');
    }
}
