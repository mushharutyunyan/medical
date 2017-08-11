<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UserOrder;
use App\Models\UserOrderDetails;
use App\Models\UserOrderMessage;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    public function index(){
        $user_orders = UserOrder::where('organization_id',Auth::guard('admin')->user()['organization_id'])->get();
        return view('admin.userOrder.index',['orders' => $user_orders]);
    }

    public function edit($id){
        $details = UserOrderDetails::where('user_order_id',$id)->get();
        $user_order = UserOrder::where('id',$id)->first();
        return view('admin.userOrder.edit',['details' => $details,'user_order' => $user_order]);
    }

    public function deleteDetail(Request $request){
        $data = $request->all();
        $detail = UserOrderDetails::where('id',$data['id'])->first();

        if($detail->user_order->organization_id == Auth::guard('admin')->user()['organization_id']){
            UserOrderDetails::where('id',$data->id)->delete();
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
}
