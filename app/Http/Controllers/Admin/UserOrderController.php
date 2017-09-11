<?php

namespace App\Http\Controllers\Admin;

use App\Models\Storage;
use App\Models\UserOrderBusy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserOrder;
use App\Models\UserOrderDetails;
use App\Models\UserOrderMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserOrderController extends Controller
{
    public function index(){
        $user_orders = UserOrder::where('organization_id',Auth::guard('admin')->user()['organization_id'])->get();
        return view('admin.userOrder.index',['orders' => $user_orders]);
    }

    public function edit($id){
        if(!$this->checkOrderBusy($id)){
            return redirect()->back();
        }
        $this->orderBusy($id);
        $details = UserOrderDetails::where('user_order_id',$id)->get();
        $user_order = UserOrder::where('id',$id)->first();
        return view('admin.userOrder.edit',['details' => $details,'user_order' => $user_order]);
    }

    public function deleteDetail(Request $request){
        $data = $request->all();
        $detail = UserOrderDetails::where('id',$data['id'])->first();

        if($detail->user_order->organization_id == Auth::guard('admin')->user()['organization_id']){
            UserOrderDetails::where('id',$data['id'])->delete();
        }
        return response()->json(true);
    }

    public function saveDetails(Request $request){
        $data = $request->all();
        $details = json_decode($data['details']);
        if(UserOrder::where('id',$data['id'])->where('organization_id',Auth::guard('admin')->user()['organization_id'])->count()){
            foreach($details as $detail){
                $current_detail = UserOrderDetails::where('id',$detail->id)->first();
                if($current_detail->user_order->organization_id == Auth::guard('admin')->user()['organization_id']){
                    UserOrderDetails::where('id',$detail->id)->update(array(
                       'count' => $detail->count,
                       'price' => $detail->price,
                    ));
                }
            }
            UserOrder::where('id',$data['id'])->update(array('status' => $data['status']));
            if(!empty($data['message'])){
                UserOrderMessage::create(array(
                    'from' => 'pharmacy',
                    'user_order_id' => $data['id'],
                    'message' => $data['message']
                ));
            }
        }
        return response()->json(true);
    }

    public function changeStatus($order_id,$status){
        UserOrder::where('id',$order_id)->update(array(
           'status' => $status
        ));
        return redirect()->back();
    }

    public function finishOrderDetails(Request $request){
        $data = $request->all();
        $order = UserOrder::where('id',$data['id'])->first();
        if($order->pay_type == UserOrder::DELIVERY){
            $pay_type = 'delivery_address';
            $take_time_delivery = $order->delivery_address;
            $delivery = true;
        }else{
            $pay_type = 'take_time';
            $take_time_delivery = $order->take_time;
            $delivery = false;
        }
        $response = array(
            'id' => $order->id,
            'pay_type_id' => $order->pay_type,
            'pay_type' => $pay_type,
            'take_time_delivery' => $take_time_delivery,
            'delivery' => $delivery
        );
        return $response;
    }

    public function finishOrder(Request $request, $user_type){
        $data = $request->all();
        if($user_type == 'pharmacy'){
            if(empty($data['take_time'])){
                $data['take_time'] = null;
            }
            if(empty($data['delivery_address'])){
                $data['delivery_address'] = null;
            }
            if(!UserOrder::where('id',$data['order_id'])->where('pay_type',$data['pay_type'])->where('take_time',$data['take_time'])->where('delivery_address',$data['delivery_address'])->count()){
                $status = UserOrder::CHANGEDBYPHARMACY;
            }else{
                $status = UserOrder::APPROVEDBYPHARMACY;
            }
        }
        $data['status'] = $status;
        $id = $data['order_id'];
        unset($data['_token']);
        unset($data['order_id']);
        if(empty($data['take_time'])){
            $data['take_time'] = null;
        }
        UserOrder::where('id',$id)->update($data);
        return response()->json(true);
    }

    public function delivery($id){
        $order_details = UserOrderDetails::where('user_order_id', $id)->get();
        foreach($order_details as $key => $details){
            $storage = $details->storage;
            $storage->count -= $details->count;
            $storage->save();
        }
        UserOrder::where('id',$id)->update(array(
            'status' => UserOrder::DELIVERED
        ));
        return response()->json(true);
    }

    public function release($order_id){
        UserOrderBusy::where('user_order_id',$order_id)->where('organization_id',Auth::guard('admin')->user()['organization_id'])->where('admin_id',Auth::guard('admin')->user()['id'])->update(array(
            'status' => 0
        ));
        return redirect()->back();
    }

    private function orderBusy($order_id){
        UserOrderBusy::where('user_order_id',$order_id)->where('organization_id',Auth::guard('admin')->user()['organization_id'])->update(array(
            'status' => 0
        ));
        if(UserOrderBusy::where('user_order_id',$order_id)->where('organization_id',Auth::guard('admin')->user()['organization_id'])->where('admin_id',Auth::guard('admin')->user()['id'])->count()){
            UserOrderBusy::where('user_order_id',$order_id)->where('organization_id',Auth::guard('admin')->user()['organization_id'])->where('admin_id',Auth::guard('admin')->user()['id'])->update(array(
                'status' => 1
            ));
        }else{
            UserOrderBusy::create(array(
                'user_order_id' => $order_id,
                'organization_id' => Auth::guard('admin')->user()['organization_id'],
                'admin_id' => Auth::guard('admin')->user()['id'],
                'status' => 1
            ));
        }
    }

    private function checkOrderBusy($order_id){
        if(UserOrderBusy::where('user_order_id',$order_id)->where('status',1)->where('admin_id','!=',Auth::guard('admin')->user()['id'])->where('organization_id',Auth::guard('admin')->user()['organization_id'])->count()){
            return false;
        }
        return true;
    }
}
