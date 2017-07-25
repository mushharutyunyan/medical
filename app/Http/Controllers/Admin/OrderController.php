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
use App\Models\OrderDeliveryStatus;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use DB;
class OrderController extends Controller
{
    public function index(){
        $orders = Order::where('from',Auth::guard('admin')->user()['organization_id'])->orWhere('to',Auth::guard('admin')->user()['organization_id'])->where('status','!=',Order::SAVED)->get();
        $status = Order::$status;
        $status_to = array(
            Order::PROCEEDFROM => $status[Order::PROCEEDFROM],
            Order::APPROVED => $status[Order::APPROVED],
            Order::CANCELED => $status[Order::CANCELED],
        );
        return view('admin.order.index',['orders' => $orders,'status' => $status, 'status_to' => $status_to]);
    }

    public function create()
    {
        $warning_drugs = Storage::where('organization_id',Auth::guard("admin")->user()['organization_id'])->where('count','<', 10)->get();
        $orders = Order::where('from',Auth::guard('admin')->user()['organization_id'])->whereNotIn('status',array(Order::APPROVED,Order::CANCELED))->get();
        $warning_drugs = Storage::warningDrugs();
        $organizations = Organization::where('status',1)->get();
        return view('admin.order.create',['organizations' => $organizations, 'warning_drugs' => $warning_drugs]);
    }

    public function store(Request $request){
        $data = $request->all();
        $status = Order::SAVED;
        if(isset($data['order_send'])){
            $status = Order::PROCEEDTO;
        }

        $data_order = array();
        $data_order['to'] = $data['to'];
        $data_order['from'] = Auth::guard('admin')->user()['organization_id'];
        $data_order['status'] = $status;
        if(isset($data_order['delivery_status_id'])){
            if($data_order['delivery_status_id'] != 0){
                $data_order['delivery_status_id'] = $data['delivery_status_id'];
            }
        }
        if(isset($data['order_delivery_address'])){
            if($data['order_delivery_address'] != 0){
                $data_order['delivery_address'] = $data['order_delivery_address'];
            }
        }
        $order = Order::create($data_order);
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
        if(Order::CANCELED == $order->status && $order->from == Auth::guard("admin")->user()['organization_id']){
            return redirect('/admin/order');
        }
        if($order->status == Order::APPROVED){
            return redirect('/admin/order');
        }
        $drugs = OrderInfo::where('order_id',$id)->get();
        $answer_order = false;
        if($order->to == Auth::guard("admin")->user()['organization_id']){
            $answer_order = true;
        }
        return view('admin.order.edit',['drugs' => $drugs,'order' => $order,'answer_order' => $answer_order]);
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

    public function update(Request $request, $id)
    {

        $data = $request->all();
        $status = Order::SAVED;
        if(isset($data['order_send'])){
            $status = Order::PROCEEDTO;
            if($data['status']){
                $status = $data['status'];
            }
        }
        if(isset($data['order_send'])){
            $drugs = json_decode($data['data']);

            OrderMessage::create(array(
                'order_id' => $id,
                'from' => Auth::guard('admin')->user()['organization_id'],
                'message' => $data['message']
            ));
            if(!empty($drugs)){
                OrderInfo::where('order_id',$id)->delete();
                foreach($drugs as $drug){
                    OrderInfo::create(array(
                        'order_id' => $id,
                        'drug_id' => $drug->drug_id,
                        'drug_settings' => $drug->settings,
                        'count' => $drug->count
                    ));
                }
            }
        }elseif($data['order_save']){
            if(isset($data['info'])){
                OrderInfo::where('order_id',$id)->delete();
                $drugs = $data['info'];
                foreach($drugs as $drug){
                    OrderInfo::create(array(
                        'order_id' => $id,
                        'drug_id' => $drug['drug_id'],
                        'drug_settings' => $drug['settings'],
                        'count' => $drug['count']
                    ));
                }
            }
        }
        $order_data = array();
        $order_data['status'] = $status;
        if($data['delivery_status_id']){
            $order_data['delivery_status_id'] = $data['delivery_status_id'];
        }
        if($data['order_delivery_address']){
            $order_data['delivery_address'] = $data['order_delivery_address'];
        }
        if(isset($data['delivery_date'])){
            if($data['delivery_date'] != 0){
                $order_data['date'] = $data['delivery_date'];
            }else{
                if($data['status'] == Order::APPROVED){
                    $data_order['date'] = date("Y-m-d H:i:s",strtotime("+3 hour"));
                }
            }
        }else{
            if($data['status'] == Order::APPROVED){
                $data_order['date'] = date("Y-m-d H:i:s",strtotime("+3 hour"));
            }
        }

        Order::where('id',$id)->update($order_data);
        return response()->json(true);
    }
    public function messages($id){
        $messages = OrderMessage::where('order_id',$id)->get();
        return response()->json($messages);
    }

    public function changeStatus(Request $request){
        $data = $request->all();
        Order::where('id',$data['id'])->update(array(
           'status' => $data['status']
        ));

        return redirect('/admin/order');
    }

    public function getAnswerStatuses(){
        $status = Order::$status;
        $statuses = array(
            Order::PROCEEDFROM => $status[Order::PROCEEDFROM],
            Order::APPROVED => $status[Order::APPROVED],
            Order::CANCELED => $status[Order::CANCELED],
        );
        return response()->json($statuses);
    }

    public function getDeliveryStatuses(){
        $delivery_statuses = OrderDeliveryStatus::all();
        return response()->json($delivery_statuses);
    }

    public function changeStatusTo(Request $request){
        $data = $request->all();
        $data_order = array();
        $data_order['status'] = $data['status'];
        if(!empty($data['delivery_date'])){
            $data_order['delivery_date'] = $data['delivery_date'];
        }else{
            if($data['status'] == Order::APPROVED){
                $data_order['date'] = date("Y-m-d H:i:s",strtotime("+3 hour"));
            }
        }
        Order::where('id',$data['id'])->update($data_order);

        OrderMessage::create(array(
           'order_id' => $data['id'],
            'from' => Auth::guard('admin')->user()['organization_id'],
            'message' => $data['message']
        ));
        return response()->json(true);
    }
}
