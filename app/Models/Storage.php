<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
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

    public static function uncheckWarningDrugs($drug_id,$drug_settings){
        return Storage::where('organization_id',Auth::guard("admin")->user()['organization_id'])->where('count','<', 10)->where('drug_id',$drug_id)->where('drug_settings',$drug_settings)->first();
    }

    public static function getWarningDrugs($unchecked_ids){
        return Storage::where('organization_id',Auth::guard("admin")->user()['organization_id'])->where('count','<', 10)->whereNotIn('id',$unchecked_ids)->get();
    }
}
