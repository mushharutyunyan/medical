<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    protected $softDelete = true;

    protected $fillable = [
        'id',
        'trade_name',
        'trade_name_ru',
        'trade_name_eng',
        'generic_name',
        'dosage_form',
        'dosage_strength',
        'code',

    ];

//    public function pictures()
//    {
//        return $this->belongsToMany('App\Models\Drug','drug_pictures', 'drug_id');
//    }
//
//    public function categories()
//    {
//        return $this->belongsToMany('App\Models\Drug','drug_categories', 'drug_id');
//    }
}
