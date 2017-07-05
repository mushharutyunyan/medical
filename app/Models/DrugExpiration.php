<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrugExpiration extends Model
{
    protected $softDelete = true;
    public $columnName = 'date';
    protected $fillable = [
        'id', 'drug_id', 'date'
    ];
}
