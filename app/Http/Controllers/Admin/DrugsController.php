<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
use App\Models\DrugReleasePackaging;
use App\Models\DrugReleaseOrder;
use App\Models\DrugSeries;
use App\Models\DrugSupplier;
use App\Models\DrugType;
use App\Models\DrugTypeBelonging;
use App\Models\DrugUnit;
use App\Models\DrugUnitPrice;
use Image;
use Input;
class DrugsController extends Controller
{
    protected $sub_fields = array('category' => DrugCategory::class,
                                    'type' => DrugType::class,
                                    'group' => DrugGroup::class,
                                    'series' => DrugSeries::class,
                                    'country' => DrugCountry::class,
                                    'manufacturer' => DrugManufacturer::class,
                                    'unit' => DrugUnit::class,
                                    'release_packaging' => DrugReleasePackaging::class,
                                    'count' => DrugPackCount::class,
                                    'unit_price' => DrugUnitPrice::class,
                                    'supplier' => DrugSupplier::class,
                                    'type_belonging' => DrugTypeBelonging::class,
                                    'certificate_number' => DrugCertificateNumber::class,
                                    'registration_date' => DrugRegistrationDate::class,
                                    'expiration_date' => DrugExpiration::class,
                                    'registration_certificate_holder' => DrugRegistrationCertificateHolder::class,
                                    'release_order' => DrugReleaseOrder::class,
                                    'character' => DrugCharacter::class,
                                    'picture' => DrugPicture::class,
                                    );
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $drugs = Drug::paginate(15);
        return view('admin.manage.drugs.index',['drugs' => $drugs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.manage.drugs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        // Main table Insert
        $drug = Drug::create(array(
            'trade_name' => $data['trade_name'],
            'trade_name_ru' => $data['trade_name_ru'],
            'trade_name_eng' => $data['trade_name_eng'],
            'generic_name' => $data['generic_name'],
            'dosage_form' => $data['dosage_form'],
            'dosage_strength' => $data['dosage_strength'],
            'code' => $data['code'],
        ));

        foreach($this->sub_fields as $sub_field => $class){
            for($i = 1; $i <= $data[$sub_field]; $i++){
                $object_class = new $class();
                if(!empty($data[$sub_field."_".$i])){
                    if($sub_field == 'picture'){
                        $picture = Input::file($sub_field."_".$i);
                        $name  = time() . '.' . $picture->getClientOriginalExtension();
                        $path = public_path('assets/admin/images/drugs/' . $name);
                        Image::make($picture->getRealPath())->resize(320, 240)->save($path);
                    }else{
                        $name = $data[$sub_field."_".$i];
                    }
                    $object_class->create(array('drug_id' => $drug->id,
                                                $object_class->columnName => $name));
                }
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $currentDrug = Drug::find($id);
//        foreach($currentDrug->categories as $categories){
//            echo "<pre>";
//            print_r($categories);die;
//        }
        return view('admin.manage.drugs.edit',['currentDrug' => $currentDrug]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
