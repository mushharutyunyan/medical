<?php

namespace App\Http\Controllers\Admin;

use App\Models\OrderInfo;
use App\Models\OrderMessage;
use App\Models\Storage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Organization;
use App\Models\Drug;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
class OrderController extends Controller
{
    public function index(){
        $orders = Order::where('to',Auth::guard('admin')->user()['organization_id'])->orWhere('from',Auth::guard('admin')->user()['organization_id'])->get();
        $status = Order::$status;
        return view('admin.order.index',['orders' => $orders,'status' => $status]);
    }

    public function create()
    {
        $warning_drugs = Storage::where('organization_id',Auth::guard("admin")->user()['organization_id'])->where('count','<', 10)->get();
        $organizations = Organization::where('status',1)->get();
        return view('admin.order.create',['organizations' => $organizations, 'warning_drugs' => $warning_drugs]);
    }

    public function store(Request $request){
        $data = $request->all();
        $status = Order::SAVED;
        if(isset($data['order_send'])){
            $status = Order::PROCEEDTO;
        }
        $order = Order::create(array('to' => $data['to'],
                                     'from' => Auth::guard('admin')->user()['organization_id'],
                                     'file' => ' ',
                                     'status' => $status));
        if(isset($data['order_send'])){
            $drugs = json_decode($data['data']);
            OrderMessage::create(array(
                'order_id' => $order->id,
                'from' => Auth::guard('admin')->user()['organization_id'],
                'message' => $data['message']
            ));
            foreach($drugs as $drug){
                OrderInfo::create(array(
                    'order_id' => $order->id,
                    'drug_id' => $drug->drug_id,
                    'drug_settings' => $drug->settings,
                    'count' => $drug->count
                ));
            }
        }elseif($data['order_save']){
            $drugs = $data['info'];
            foreach($drugs as $drug){
                OrderInfo::create(array(
                    'order_id' => $order->id,
                    'drug_id' => $drug['drug_id'],
                    'drug_settings' => $drug['settings'],
                    'count' => $drug['count']
                ));
            }
        }


        return response()->json(true);
    }
    public function edit($id)
    {
        $order = Order::where('id',$id)->first();
        $drugs = OrderInfo::where('order_id',$id)->get();
        return view('admin.order.edit',['drugs' => $drugs,'order' => $order]);
    }

    public function show(Request $request,$id){
        $data = $request->all();
        $order = OrderInfo::where('order_id',$id)->where('drug_id',$data['drug_id'])->first();
        $currentDrug = Drug::find($data['drug_id']);
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
        return response()->json(array("order" => $order, "drug" => $currentDrug));

    }
    public function messages($id){
        $messages = OrderMessage::where('order_id',$id)->get();
        return response()->json($messages);
    }
}
