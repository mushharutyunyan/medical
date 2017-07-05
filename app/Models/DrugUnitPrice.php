<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrugUnitPrice extends Model
{
    protected $softDelete = true;
    public $columnName = 'price';
    protected $fillable = [
        'id', 'drug_id', 'price'
    ];
}
