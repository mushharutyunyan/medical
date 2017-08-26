<?php

namespace App\Models;

use App\Support\Arrays;
use Illuminate\Support\Facades\Lang;

class Drug extends AbstractModel
{
    protected $softDelete = true;

    protected $fillable = [
        'id',
        'trade_name',
        'trade_name_ru',
        'trade_name_en',
        'generic_name',
        'dosage_form',
        'dosage_strength',
        'code',

    ];
    public $settings = array(
        'category',
        'certificate_number',
        'country',
        'expiration_date',
        'group',
        'manufacturer',
        'count',
        'picture',
        'registration_certificate_holder',
        'registration_date',
        'release_packaging',
        'release_order',
        'series',
        'supplier',
        'type',
        'type_belonging',
        'unit',
        'unit_price',
        'character',
        'storage',
    );


    public function setting_names(){
        return array(
        'category' => Lang::get('main.category'),
        'certificate_number' => Lang::get('main.certificate_number'),
        'country' => Lang::get('main.country'),
        'expiration_date' => Lang::get('main.expiration_date'),
        'group' => Lang::get('main.group'),
        'manufacturer' => Lang::get('main.manufacturer'),
        'count' => Lang::get('main.count'),
        'picture' => Lang::get('main.picture'),
        'registration_certificate_holder' => Lang::get('main.registration_certificate_holder'),
        'registration_date' => Lang::get('main.registration_date'),
        'release_packaging' => Lang::get('main.release_packaging'),
        'release_order' => Lang::get('main.release_order'),
        'series' => Lang::get('main.series'),
        'supplier' => Lang::get('main.supplier'),
        'type' => Lang::get('main.type'),
        'type_belonging' => Lang::get('main.type_belonging'),
        'unit' => Lang::get('main.unit'),
        'unit_price' => Lang::get('main.unit_price'),
        'character' => Lang::get('main.character'),
        'storage' => Lang::get('main.storage'),
        );
    }

    public function category()
    {
        return $this->hasMany('App\Models\DrugCategory','drug_id');
    }

    public function certificate_number()
    {
        return $this->hasMany('App\Models\DrugCertificateNumber','drug_id');
    }

    public function country()
    {
        return $this->hasMany('App\Models\DrugCountry','drug_id');
    }

    public function expiration_date()
    {
        return $this->hasMany('App\Models\DrugExpiration','drug_id');
    }

    public function group()
    {
        return $this->hasMany('App\Models\DrugGroup','drug_id');
    }

    public function manufacturer()
    {
        return $this->hasMany('App\Models\DrugManufacturer','drug_id');
    }

    public function count()
    {
        return $this->hasMany('App\Models\DrugPackCount','drug_id');
    }

    public function picture()
    {
        return $this->hasMany('App\Models\DrugPicture','drug_id');
    }

    public function registration_certificate_holder()
    {
        return $this->hasMany('App\Models\DrugRegistrationCertificateHolder','drug_id');
    }

    public function registration_date()
    {
        return $this->hasMany('App\Models\DrugRegistrationDate','drug_id');
    }

    public function release_packaging()
    {
        return $this->hasMany('App\Models\DrugReleasePackaging','drug_id');
    }

    public function release_order()
    {
        return $this->hasMany('App\Models\DrugReleaseOrder','drug_id');
    }

    public function series()
    {
        return $this->hasMany('App\Models\DrugSeries','drug_id');
    }

    public function supplier()
    {
        return $this->hasMany('App\Models\DrugSupplier','drug_id');
    }

    public function type()
    {
        return $this->hasMany('App\Models\DrugType','drug_id');
    }

    public function type_belonging()
    {
        return $this->hasMany('App\Models\DrugTypeBelonging','drug_id');
    }

    public function unit()
    {
        return $this->hasMany('App\Models\DrugUnit','drug_id');
    }

    public function unit_price()
    {
        return $this->hasMany('App\Models\DrugUnitPrice','drug_id');
    }

    public function character()
    {
        return $this->hasMany('App\Models\DrugCharacter','drug_id');
    }

    public function storage()
    {
        return $this->hasMany('App\Models\Storage','drug_id');
    }

    public function syncOptions(array $options, $column = 'option')
    {
        $new_options = array_filter($options);
        $old_options = $this->options->lists($column, 'id');

        // Delete removed options, if any
        if ($deleted = Arrays::keysDeleted($new_options, $old_options)) {
            $this->options()->whereIn('id', $deleted)->delete();
        }

        // Create new options, if any
        if ($created = Arrays::keysCreated($new_options, $old_options)) {
            foreach ($created as $id) {
                $new[] = $this->options()->getModel()->newInstance([
                    $column => $new_options[$id],
                ]);
            }

            $this->options()->saveMany($new);
        }

        // Update changed options, if any
        if ($updated = Arrays::keysUpdated($new_options, $old_options)) {
            foreach ($updated as $id) {
                $this->options()->find($id)->update([
                    $column => $new_options[$id],
                ]);
            }
        }
    }

}
