<?php

namespace App\Http\Controllers\Admin;

use App\Models\Drug;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Storage;
use Illuminate\Support\Facades\Auth;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $storage = Storage::paginate(15);
        return view('admin.storage.index',['storages' => $storage]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.storage.create');
    }

    public function show($id){
        $storage = Storage::find($id);
        $currentDrug = Drug::find($storage->drug_id);
        $currentDrug->category;
        $currentDrug->certificate_number;
        $currentDrug->country;
        $currentDrug->expiration_date;
        $currentDrug->group;
        $currentDrug->manufacturer;
        $currentDrug->count;
        $currentDrug->picture;
        $currentDrug->registration_certificate_holder;
        $currentDrug->registration_date;
        $currentDrug->release_packaging;
        $currentDrug->release_order;
        $currentDrug->series;
        $currentDrug->supplier;
        $currentDrug->type;
        $currentDrug->type_belonging;
        $currentDrug->unit;
        $currentDrug->unit_price;
        $currentDrug->character;
        return response()->json(array("storage" => $storage, "drug" => $currentDrug));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $storage = Storage::find($id);
        $currentDrug = Drug::find($storage->drug_id);
        $settings_info = [];
        $settings_info['category'] = 'Categories';
        $settings_info['count'] = 'Count';
        $settings_info['unit_price'] = 'Unit Price';
        $settings_info['country'] = 'Country';
        $settings_info['expiration_date'] = 'Expiration date';
        $settings_info['registration_date'] = 'Registration Date';
        $settings_info['group'] = 'Group';
        $settings_info['manufacturer'] = 'Manufacturer';
        $settings_info['series'] = 'Series';
        $settings_info['supplier'] = 'Supplier';
        $settings_info['type'] = 'Type';
        $settings_info['unit'] = 'Unit';
        $settings_info['certificate_number'] = 'Certificate Number';
        $settings_info['release_order'] = 'Release Order';
        $settings_info['release_packaging'] = 'Release Packaging';
        $settings_info['type_belonging'] = 'Type Belonging';
        $settings_info['registration_certificate_holder'] = 'Registration Certificate Holder';
        $settings_info['character'] = 'Character';
        $settings_info['picture'] = 'Picture';

        $currentSettings = json_decode($storage->drug_settings);
        return view('admin.storage.edit',['storage' => $storage, 'currentDrug' => $currentDrug, 'settings_info' => $settings_info, 'currentSettings' => $currentSettings]);
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
        $data = $request->all();
        unset($data['_method']);
        unset($data['_token']);
        $settings = array();
        foreach($data as $key => $value){
            if($key != 'drug_id' && $key != 'storage_count'){
                if(!empty($value)){
                    $settings[$key] = $value;
                }
            }
        }
        $drug_settings = json_encode($settings);
        $checkDrug = Storage::where('id','!=',$id)->where('drug_id',$data['drug_id'])->where('drug_settings',$drug_settings)->first();
        if($checkDrug){
            return response()->json(array('exist' => $checkDrug->id));
        }
        Storage::where('id','=',$id)->update(array('count' => $data['storage_count'],'drug_settings' => $drug_settings));
        return response()->json(true);
    }

    public function searchDrug(Request $request){
        $this->validate($request, [
            'name' => 'required|min:2',
        ]);
        $data = $request->all();
        $name = trim($data['name']);
        $drugs = Drug::where('trade_name','LIKE',"%".$name."%")
            ->orWhere('trade_name_ru','LIKE',"%".$name."%")
            ->orWhere('trade_name_en','LIKE',"%".$name."%")->orderBy('trade_name','ASC')->get();
        return response()->json($drugs);
    }

    public function searchDrugSettings(Request $request){
        $data = $request->all();
        $currentDrug = Drug::find($data['id']);
        $currentDrug->category;
        $currentDrug->certificate_number;
        $currentDrug->country;
        $currentDrug->expiration_date;
        $currentDrug->group;
        $currentDrug->manufacturer;
        $currentDrug->count;
        $currentDrug->picture;
        $currentDrug->registration_certificate_holder;
        $currentDrug->registration_date;
        $currentDrug->release_packaging;
        $currentDrug->release_order;
        $currentDrug->series;
        $currentDrug->supplier;
        $currentDrug->type;
        $currentDrug->type_belonging;
        $currentDrug->unit;
        $currentDrug->unit_price;
        $currentDrug->character;
        return response()->json(['currentDrug' => $currentDrug]);

    }
    public function checkDrug(Request $request){
        $data = $request->all();
        $settings = json_encode($data['info']);
        $exist_drug = Storage::where('organization_id',Auth::guard('admin')->user()['organization_id'])
            ->where('drug_id',$data['drug_id'])
            ->where('drug_settings',$settings)->count();
        return response()->json($exist_drug);
    }

    public function saveAll(Request $request){
        $data = $request->all();
        foreach($data['info'] as $value){
            $this->save($request, $value);
        }
        return response()->json(true);
    }

    public function save(Request $request, $data = null){
        if(!$data){
            $data = Request::all();
            $this->validate($request, [
                'count' => 'required|numeric',
            ]);
        }
        if($data['exist']){
            $exist = Storage::where('organization_id',Auth::guard('admin')->user()['organization_id'])
                ->where('drug_id',$data['drug_id'])
                ->where('drug_settings',$data['settings'])->first();
            Storage::where('organization_id',Auth::guard('admin')->user()['organization_id'])
                ->where('drug_id',$data['drug_id'])
                ->where('drug_settings',$data['settings'])->update(array('count'=>($data['count'] + $exist->count)));
            return response()->json(true);
        }
        Storage::create(array(
            'drug_settings' => $data['settings'],
            'drug_id' => $data['drug_id'],
            'organization_id' => Auth::guard('admin')->user()['organization_id'],
            'count' => $data['count'],
        ));
        return response()->json(true);
    }


}
