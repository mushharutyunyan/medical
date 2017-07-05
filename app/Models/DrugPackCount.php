<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrugPackCount extends Model
{
    protected $softDelete = true;
    public $columnName = 'count';
    protected $fillable = [
        'id', 'drug_id', 'count'
    ];
}
