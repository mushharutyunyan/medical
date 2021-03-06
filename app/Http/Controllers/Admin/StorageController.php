<?php

namespace App\Http\Controllers\Admin;

use App\Models\Drug;
use App\Models\DrugUnitPrice;
use App\Models\OrderDiscount;
use App\Models\OrderInfo;
use App\Models\Organization;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Storage;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::guard('admin')->user()->role->id != 1 && Auth::guard('admin')->user()->role->id != 2){ // not superadmin and admin
            $storage = Storage::where('organization_id',Auth::guard('admin')->user()['organization_id'])->paginate(15);
            $view = 'admin.storage.index';
            $admin_organizations = '';
            $list = false;
            $organization_name = Auth::guard('admin')->user()->organization->name;
            $request->session()->put('organization_id',Auth::guard('admin')->user()->organization->id);
            $request->session()->put('organization_name',$organization_name);
        }else{
            $admin_organizations = Auth::guard('admin')->user()->admin_organizations()->get();
            $storage = Storage::paginate(15);
            $view = 'admin.storage.list';
            $list = true;
            $organization_name = '';
        }
        $status = Organization::STATUS;
        return view($view,['storages' => $storage,'admin_organizations' => $admin_organizations,'status' => $status, 'list' => $list, 'organization_name' => $organization_name]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        return view('admin.storage.create');
    }

    public function show($id,Request $request){
        if(!$request->ajax()){
            $storage = Storage::where('organization_id',$id)->paginate(15);
            $view = 'admin.storage.index';
            $admin_organizations = '';
            $list = true;
            $status = Organization::STATUS;
            $organization = Organization::where('id',$id)->first();
            $organization_name = $organization->name;
            $request->session()->put('organization_id',$organization->id);
            $request->session()->put('organization_name',$organization_name);
            return view($view,['storages' => $storage,'admin_organizations' => $admin_organizations,'status' => $status, 'list' => $list, 'organization_name' => $organization_name]);
        }
        $storage = Storage::find($id);
        $storage->price;
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
        $settings_info['count'] = 'Unit Count';
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
        $organization_id = $request->session()->get('organization_id');
        unset($data['_method']);
        unset($data['_token']);
        $settings = array();
        foreach($data as $key => $value){
            if($key != 'drug_id' && $key != 'storage_count' && $key != 'price'){
                if(!empty($value)){
                    $settings[$key] = $value;
                }
            }
        }
        $price = number_format($data['price'],2,".","");
        if(!DrugUnitPrice::where('drug_id',$data['drug_id'])->where('price',$price)->count()){
            $drug_unit_price = DrugUnitPrice::create(array(
                'drug_id' => $data['drug_id'],
                'price' => $price
            ));
        }else{
            $drug_unit_price = DrugUnitPrice::where('drug_id',$data['drug_id'])->where('price',$price)->first();
        }
        unset($data['price']);
        $data['price_id'] = $drug_unit_price->id;
        $drug_settings = json_encode($settings);
        $checkDrug = Storage::where('id','!=',$id)->where('organization_id',$organization_id)->where('drug_id',$data['drug_id'])->where('drug_settings',$drug_settings)->first();
        if($checkDrug){
            return response()->json(array('exist' => $checkDrug->id));
        }
        Storage::where('id','=',$id)->update(array('count' => $data['storage_count'],'drug_settings' => $drug_settings,'price_id' => $data['price_id']));
        return response()->json(true);
    }

    public function searchDrug(Request $request){
        $this->validate($request, [
            'name' => 'required|min:2',
        ]);
        $data = $request->all();
        $name = trim($data['name']);
        if($data['is_order'] != 'false'){
            if($data['to'] == 0){
                return response()->json(['error' => 'Please choose organization']);
            }else{
                $storage = Storage::whereHas('drug', function ($query) use ($name){
                    $query->where('trade_name','LIKE',"%".$name."%")
                        ->orWhere('trade_name_ru','LIKE',"%".$name."%")
                        ->orWhere('trade_name_en','LIKE',"%".$name."%")
                        ->orWhere('code',$name);
                })->where('organization_id',$data['to'])->get();
                $drugs = array();
                foreach($storage as $value){
                    $drugs[] = array(
                        'id' => $value->id,
                        'trade_name' => $value->drug->trade_name,
                    );
                }
                return response()->json($drugs);
            }
        }
        $drugs = Drug::where('trade_name','LIKE',"%".$name."%")
            ->orWhere('trade_name_ru','LIKE',"%".$name."%")
            ->orWhere('trade_name_en','LIKE',"%".$name."%")
            ->orWhere('code',$name)
            ->orderBy('trade_name','ASC')->get();
        return response()->json($drugs);
    }

    public function searchDrugSettings(Request $request, Drug $drug){
        $data = $request->all();
        $storage = '';
        if($data['is_order'] != 'false'){
            $storage = Storage::where('id',$data['id'])->first();
            $currentDrug = $storage->drug;
        }else{
            $currentDrug = Drug::find($data['id']);
        }
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

        return response()->json(['currentDrug' => $currentDrug,'storage' => $storage,'setting_names' => $drug->setting_names(),'settings' => $drug->settings]);

    }
    public function checkDrug(Request $request){
        $data = $request->all();
        $organization_id = $request->session()->get('organization_id');
        if($data['is_order']){
            $checked_drug = Storage::where('id',$data['storage_id'])->first();
            $drug_id = $checked_drug->drug_id;
            $settings = $checked_drug->drug_settings;
            $orders = Order::where('from',Auth::guard('admin')->user()['organization_id'])->whereNotIn('status',array(Order::APPROVED,Order::CANCELED))->get();
            foreach($orders as $order){
                if(OrderInfo::where('order_id',$order->id)->where('storage_id',$data['storage_id'])->count()){
                    $exist_drug = OrderInfo::where('order_id',$order->id)->where('storage_id',$data['storage_id'])->first();
                    $storage = Storage::where('id',$data['storage_id'])->first();
                    $discount = OrderDiscount::where('whole_sale',$storage->organization_id)->where('pharmacy',Auth::guard('admin')->user()['organization_id'])->first();
                    $discount_proceent = 0;
                    if($discount){
                        $discount_proceent = $discount->discount;
                    }
                    return response()->json(array(
                        'error' => 'This drug has already in your order list',
                        'count' => $exist_drug->count,
                        'price' => $storage->price->price,
                        'discount' => $discount_proceent
                    ));
                }
            }
        }else{
            $settings = json_encode($data['info']);
            $drug_id = $data['drug_id'];
        }
        $exist_drug = Storage::where('organization_id',$organization_id)
            ->where('drug_id',$drug_id)
            ->where('drug_settings',$settings)->count();
        if($exist_drug){
            $exist_drug = Storage::where('organization_id',$organization_id)
                ->where('drug_id',$drug_id)
                ->where('drug_settings',$settings)->first();
            $exist_drug->price;
        }

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
        $organization_id = $request->session()->get('organization_id');
        if(!$data){
            $data = Input::all();
            $this->validate($request, [
                'count' => 'required|numeric',
                'price' => 'required|numeric',
            ]);
        }
        $drug_settings = $data['settings'];

        $price = number_format($data['price'],2,".","");
        if(!DrugUnitPrice::where('drug_id',$data['drug_id'])->where('price',$price)->count()){
            $drug_unit_price = DrugUnitPrice::create(array(
                'drug_id' => $data['drug_id'],
                'price' => $price
            ));
        }else{
            $drug_unit_price = DrugUnitPrice::where('drug_id',$data['drug_id'])->where('price',$price)->first();
        }
        if($data['exist']){
            $exist = Storage::where('organization_id',$organization_id)
                ->where('drug_id',$data['drug_id'])
                ->where('drug_settings',$drug_settings)->first();
            Storage::where('organization_id',$organization_id)
                ->where('drug_id',$data['drug_id'])
                ->where('drug_settings',$drug_settings)->update(array('count'=>($data['count'] + $exist->count),
                                                                      'price_id' => $drug_unit_price->id));
            return response()->json(true);
        }
        Storage::create(array(
            'drug_settings' => $data['settings'],
            'drug_id' => $data['drug_id'],
            'organization_id' => $organization_id,
            'count' => $data['count'],
            'price_id' => $drug_unit_price->id,
        ));
        return response()->json(true);
    }


}
