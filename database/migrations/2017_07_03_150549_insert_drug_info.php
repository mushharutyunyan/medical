<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Drug;
use App\Models\DrugCategory;
use App\Models\DrugCertificateNumber;
use App\Models\DrugCharacter;
use App\Models\DrugCountry;
use App\Models\DrugExpiration;
use App\Models\DrugGroup;
use App\Models\DrugManufacturer;
use App\Models\DrugPackCount;
use App\Models\DrugPicture;
use App\Models\DrugRegistrationCertificateHolder;
use App\Models\DrugRegistrationDate;
use App\Models\DrugReleaseForm;
use App\Models\DrugReleasePackaging;
use App\Models\DrugReleaseOrder;
use App\Models\DrugSeries;
use App\Models\DrugSupplier;
use App\Models\DrugType;
use App\Models\DrugTypeBelonging;
use App\Models\DrugUnit;
use App\Models\DrugUnitPrice;
use Maatwebsite\Excel\Facades\Excel;
class InsertDrugInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        ini_set('memory_limit', '-1');
//        $results = Excel::load('storage/archive/drugs.xlsx')->all()->toArray();
//        $drugs = array();
//        $categories = array();
//        $groups = array();
//        $types = array();
//        $series = array();
//        $countries = array();
//        $manufacturers = array();
//        $units = array();
//        $release_packagings = array();
//        $counts = array();
//        $unit_prices = array();
//        $suppliers = array();
//        $types_belonging = array();
//        $certificate_numbers = array();
//        $registration_dates = array();
//        $registration_certificate_holders = array();
//        $characters = array();
//        $pictures = array();
//        $expiration_dates = array();
//        foreach($results as $result){
//            if(Drug::where('trade_name',$result['trade_name_torgovoe_nazvanie'])->count()){
//                continue;
//            }
//            if(!in_array($result['trade_name_torgovoe_nazvanie'],$drugs)){
//                $drug = Drug::create(array(
//                    'trade_name' => $result['trade_name_torgovoe_nazvanie'],
//                    'trade_name_ru' => $result['trade_name_ru'],
//                    'trade_name_en' => $result['trade_name_eng'],
//                    'generic_name' => $result['generic_name_veshchestvo'],
//                    'dosage_form' => $result['dosage_formforma'],
//                    'dosage_strength' => $result['dosage_strength_dozirovka'],
//                    'code' => $result['code'],
//                ));
//                $drugs[$drug->id] = $drug->trade_name;
//            }else{
//                $drug = Drug::orderBy('id','DESC')->first();
//            }
//
//            if(!empty($result['category'])){
//                $access = true;
//                foreach($categories as $category){
//                    if($category['drug_id'] == $drug->id && $category['name'] == $result['category']){
//                        $access = false;
//                    }
//                }
//                if($access){
//                    $category = array(
//                        'drug_id' => $drug->id,
//                        'name' => $result['category']
//                    );
//                    DrugCategory::create($category);
//                    $categories[] = $category;
//                }
//            }
//
//            if(!empty($result['group'])){
//                $access = true;
//                foreach($groups as $group){
//                    if($group['drug_id'] == $drug->id && $group['name'] == $result['group']){
//                        $access = false;
//                    }
//                }
//                if($access){
//                    $group = array(
//                        'drug_id' => $drug->id,
//                        'name' => $result['group']
//                    );
//                    DrugGroup::create($group);
//                    $groups[] = $group;
//                }
//            }
//
//            if(!empty($result['type'])){
//                $access = true;
//                foreach($types as $type){
//                    if($type['drug_id'] == $drug->id && $type['name'] == $result['type']){
//                        $access = false;
//                    }
//                }
//                if($access){
//                    $type = array(
//                        'drug_id' => $drug->id,
//                        'name' => $result['type']
//                    );
//                    DrugType::create($type);
//                    $types[] = $type;
//                }
//            }
//
//            if(!empty($result['series'])){
//                $access = true;
//                foreach($series as $value){
//                    if($value['drug_id'] == $drug->id && $value['name'] == $result['series']){
//                        $access = false;
//                    }
//                }
//                if($access){
//                    $ser = array(
//                        'drug_id' => $drug->id,
//                        'name' => $result['series']
//                    );
//                    DrugSeries::create($ser);
//                    $series[] = $ser;
//                }
//            }
//
//            if(!empty($result['country'])){
//                $access = true;
//                foreach($countries as $country){
//                    if($country['drug_id'] == $drug->id && $country['name'] == $result['country']){
//                        $access = false;
//                    }
//                }
//                if($access){
//                    $country = array(
//                        'drug_id' => $drug->id,
//                        'name' => $result['country']
//                    );
//                    DrugCountry::create($country);
//                    $countries[] = $country;
//                }
//            }
//
//            if(!empty($result['manufacturer'])){
//                $access = true;
//                foreach($manufacturers as $manufacturer){
//                    if($manufacturer['drug_id'] == $drug->id && $manufacturer['name'] == $result['manufacturer']){
//                        $access = false;
//                    }
//                }
//                if($access){
//                    $manufacturer = array(
//                        'drug_id' => $drug->id,
//                        'name' => $result['manufacturer']
//                    );
//                    DrugManufacturer::create($manufacturer);
//                    $manufacturers[] = $manufacturer;
//                }
//            }
//
//            if(!empty($result['unit_izmerenie'])){
//                $access = true;
//                foreach($units as $unit){
//                    if($unit['drug_id'] == $drug->id && $unit['name'] == $result['unit_izmerenie']){
//                        $access = false;
//                    }
//                }
//                if($access){
//                    $unit = array(
//                        'drug_id' => $drug->id,
//                        'name' => $result['unit_izmerenie']
//                    );
//                    DrugUnit::create($unit);
//                    $units[] = $unit;
//                }
//            }
//
//            if(!empty($result['release_packaging_forma_proizvodstva_tip_upakovki'])){
//                $access = true;
//                foreach($release_packagings as $release_packaging){
//                    if($release_packaging['drug_id'] == $drug->id && $release_packaging['name'] == $result['release_packaging_forma_proizvodstva_tip_upakovki']){
//                        $access = false;
//                    }
//                }
//                if($access){
//                    $release_packagings = array(
//                        'drug_id' => $drug->id,
//                        'name' => $result['release_packaging_forma_proizvodstva_tip_upakovki']
//                    );
//                    DrugReleasePackaging::create($release_packaging);
//                    $release_packagings[] = $release_packaging;
//                }
//            }
//
//            if(!empty($result['count_kolichestvo_v_upakovke_n_tip_upakovki_n'])){
//                $access = true;
//                foreach($counts as $count){
//                    if($count['drug_id'] == $drug->id && $count['count'] == $result['count_kolichestvo_v_upakovke_n_tip_upakovki_n']){
//                        $access = false;
//                    }
//                }
//                if($access){
//                    $count = array(
//                        'drug_id' => $drug->id,
//                        'count' => $result['count_kolichestvo_v_upakovke_n_tip_upakovki_n']
//                    );
//                    DrugPackCount::create($count);
//                    $counts[] = $count;
//                }
//            }
//
//            if(!empty($result['unit_price'])){
//                $access = true;
//                foreach($unit_prices as $unit_price){
//                    if($unit_price['drug_id'] == $drug->id && $unit_price['price'] == $result['unit_price']){
//                        $access = false;
//                    }
//                }
//                if($access){
//                    $unit_price = array(
//                        'drug_id' => $drug->id,
//                        'price' => $result['unit_price']
//                    );
//                    DrugUnitPrice::create($unit_price);
//                    $unit_prices[] = $unit_price;
//                }
//            }
//
//            if(!empty($result['supplier_postavshchik'])){
//                $access = true;
//                foreach($suppliers as $supplier){
//                    if($supplier['drug_id'] == $drug->id && $supplier['name'] == $result['supplier_postavshchik']){
//                        $access = false;
//                    }
//                }
//                if($access){
//                    $supplier = array(
//                        'drug_id' => $drug->id,
//                        'name' => $result['supplier_postavshchik']
//                    );
//                    DrugSupplier::create($supplier);
//                    $suppliers[] = $supplier;
//                }
//            }
//
//            if(!empty($result['type_belonging'])){
//                $access = true;
//                foreach($types_belonging as $type_belonging){
//                    if($type_belonging['drug_id'] == $drug->id && $type_belonging['name'] == $result['type_belonging']){
//                        $access = false;
//                    }
//                }
//                if($access){
//                    $type_belonging = array(
//                        'drug_id' => $drug->id,
//                        'price' => $result['type_belonging']
//                    );
//                    DrugTypeBelonging::create($type_belonging);
//                    $types_belonging[] = $type_belonging;
//                }
//            }
//
//            if(!empty($result['certificate_number'])){
//                $access = true;
//                foreach($certificate_numbers as $certificate_number){
//                    if($certificate_number['drug_id'] == $drug->id && $certificate_number['name'] == $result['certificate_number']){
//                        $access = false;
//                    }
//                }
//                if($access){
//                    $certificate_number = array(
//                        'drug_id' => $drug->id,
//                        'price' => $result['certificate_number']
//                    );
//                    DrugCertificateNumber::create($certificate_number);
//                    $certificate_numbers[] = $certificate_number;
//                }
//            }
//
//            if(!empty($result['registration_date'])){
//                $access = true;
//                foreach($registration_dates as $registration_date){
//                    if($registration_date['drug_id'] == $drug->id && $registration_date['date'] == $result['registration_date']){
//                        $access = false;
//                    }
//                }
//                if($access){
//                    $registration_date = array(
//                        'drug_id' => $drug->id,
//                        'date' => $result['registration_date']
//                    );
//                    DrugRegistrationDate::create($registration_date);
//                    $registration_dates[] = $registration_date;
//                }
//            }
//
//            if(!empty($result['registration_certificate_holder'])){
//                $access = true;
//                foreach($registration_certificate_holders as $registration_certificate_holder){
//                    if($registration_certificate_holder['drug_id'] == $drug->id && $registration_certificate_holder['name'] == $result['registration_certificate_holder']){
//                        $access = false;
//                    }
//                }
//                if($access){
//                    $registration_certificate_holder = array(
//                        'drug_id' => $drug->id,
//                        'name' => $result['registration_certificate_holder']
//                    );
//                    DrugRegistrationCertificateHolder::create($registration_certificate_holder);
//                    $registration_certificate_holders[] = $registration_certificate_holder;
//                }
//            }
//
//            if(!empty($result['character'])){
//                $access = true;
//                foreach($characters as $character){
//                    if($character['drug_id'] == $drug->id && $character['name'] == $result['character']){
//                        $access = false;
//                    }
//                }
//                if($access){
//                    $character = array(
//                        'drug_id' => $drug->id,
//                        'name' => $result['character']
//                    );
//                    DrugCharacter::create($character);
//                    $characters[] = $character;
//                }
//            }
//
//            if(!empty($result['picture'])){
//                $access = true;
//                foreach($pictures as $picture){
//                    if($picture['drug_id'] == $drug->id && $picture['name'] == $result['picture']){
//                        $access = false;
//                    }
//                }
//                if($access){
//                    $picture = array(
//                        'drug_id' => $drug->id,
//                        'name' => $result['picture']
//                    );
//                    DrugPicture::create($picture);
//                    $pictures[] = $picture;
//                }
//            }
//
//            if(!empty($result['expiration_date'])){
//                $access = true;
//                foreach($expiration_dates as $expiration_date){
//                    if($expiration_date['drug_id'] == $drug->id && $expiration_date['date'] == date('Y-m-d',strtotime("01/".$result['expiration_date']))){
//                        $access = false;
//                    }
//                }
//                if($access){
//                    $expiration_date = array(
//                        'drug_id' => $drug->id,
//                        'date' => date('Y-m-d',strtotime("01/".$result['expiration_date']))
//                    );
//                    DrugExpiration::create($expiration_date);
//                    $expiration_dates[] = $expiration_date;
//                }
//            }
//        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
