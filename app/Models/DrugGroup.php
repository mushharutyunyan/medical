<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DrugGroup extends Model
{
    protected $softDelete = true;
    public $columnName = 'name';
    protected $fillable = [
        'id', 'drug_id', 'name'
    ];

}
