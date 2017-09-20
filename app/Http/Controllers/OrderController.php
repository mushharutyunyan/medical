<?php

namespace App\Http\Controllers;

use App\Models\OrderMessage;
use App\Models\Organization;
use App\Models\OrganizationLocation;
use App\Models\User;
use App\Models\UserOrder;
use App\Models\UserOrderDetails;
use App\Models\UserOrderMessage;
use App\Models\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Location;
use Lang;
use App;
class OrderController extends Controller
{
    public function index(){
        $organizations = Organization::where('status',Organization::PHARMACY)->get();
        return view('order',['organizations' => $organizations]);
    }

    public function getOrganizations(Request $request){
        $organizations = Organization::where('status',Organization::PHARMACY)->get();
        $data = array();
        foreach ($organizations as $organization){
            if(OrganizationLocation::where('organization_id',$organization->id)->count()){
                $data[] = [$organization->name,$organization->location[0]->latitude,$organization->location[0]->longitude,$organization->id,$organization->city.' '.$organization->street.' '.$organization->appartment,$organization->phone];
            }
        }
        $position = Location::get($request->ip());
        return response()->json(array("data" => $data,"position" => $position));
    }

    public function addBasket(Request $request){
        $data = $request->all();
        $orders = Session::get('order');
        $count = count($orders);
        if($orders){
            foreach($orders as $order){
                if($order['storage_id'] == $data['storage_id']){
                    return response()->json(false);
                }
            }
            array_push($orders,$data);
            Session::put('order',$orders);
            return response()->json(true);
        }
        Session::put('order',array($data));
        $request->session()->put('order', array($data));
        return response()->json(true);
    }

    public function deleteBasket(Request $request){
        $data = $request->all();
        $old_orders = Session::get('order');
        $orders = array();
        foreach($old_orders as $order){
            if($order['storage_id'] != $data['storage_id']){
                $orders[] = $order;
            }
        }
        if(empty($orders)){
            $request->session()->forget('order');
            return response()->json(true);
        }
        $request->session()->put('order', $orders);
        return response()->json(true);
    }

    public function updateBasket(Request $request){
        $data = $request->all();
        $request->session()->forget('order');
        unset($data['_token']);
        $request->session()->put('order', $data);
        $old_orders = Session::get('order');
        return response()->json(true);
    }

    public function cart(){
        return view('cart');
    }

    public function checkout(Request $request){
        $orders = Session::get('order');
        if(empty($orders)){
            return redirect()->back()->withErrors(['emptyBasket' => Lang::get('main.basketEmptyError')]);
        }
        $user_id = null;
        if(Auth::check()){
            $user_id = Auth::user()['id'];
        }
        $user_order = UserOrder::create(array(
            'user_id' => $user_id,
            'organization_id' => $orders[0]['organization_id'],
            'status' => UserOrder::SENDED
        ));
        foreach($orders as $order){
            UserOrderDetails::create(array(
               'user_order_id' => $user_order->id,
                'storage_id' => $order['storage_id'],
                'price' => $order['price'],
                'count' => $order['count'],
            ));
        }
        $order = substr(uniqid(), 0, 10);
        UserOrder::where('id',$user_order->id)->update(array(
           'order' => $order
        ));
        $request->session()->forget('order');
        if(Auth::check()){
            return redirect('/')->with(['orderDetails' => Lang::get('main.orderFinishMessageAuth')]);
        }else{
            return redirect('/')->with(['orderDetails' => Lang::get('main.orderFinishMessage',['orderId' => $order])]);
        }
    }

    public function details(Request $request){
        $page = 'searchOrder';
        if(Auth::check()){
            if($request->isMethod('post')){
                $data = $request->all();
                if(empty($data['search'])){
                    return redirect()->back();
                }
                $user_orders = UserOrder::where('user_id',Auth::user()['id'])
                    ->whereHas('organization', function ($q) use($data) {
                        $q->where('name', 'like', '%'.$data['search'].'%');
                    })
                    ->orWhere('order','like','%'.$data['search'].'%')
                    ->orWhere('delivery_time','like','%'.$data['search'].'%')
                    ->orWhere('updated_at','like','%'.$data['search'].'%')
                    ->orderBy('id','DESC')->paginate(10);
                $search = $data['search'];
            }else{
                $user_orders = UserOrder::where('user_id',Auth::user()['id'])->orderBy('id','DESC')->paginate(10);
                $search = '';
            }
            $page = 'historyOrder';
            return view($page,['orders' => $user_orders,'search' => $search]);
        }
        return view($page);
    }

    public function getDetails(Request $request){
        $data = $request->all();
        if(!$request->ajax()){
            if(empty($data['searchOrder'])){
                return redirect()->back();
            }
            $user_order = UserOrder::where('order',$data['searchOrder'])->first();
            if(!$user_order){
                return redirect()->back()->withErrors(['error' => Lang::get('main.orderNotFound')]);
            }
            UserOrderMessage::where('user_order_id',$user_order->id)->update(array(
                'read' => 1
            ));
        }else{
            $user_order = UserOrder::where('id',$data['id'])->first();
            if(!$user_order){
                return response()->json(['error' => Lang::get('main.orderNotFound')]);
            }
        }

        $messages = UserOrderMessage::where('user_order_id',$user_order->id)->get();
        if(!$request->ajax()){
            return view('searchOrder',['details' => $user_order,'messages' => $messages]);
        }else{
            $details = array();
            foreach($user_order->order_details as $drugs){
                if(App::getLocale('am')){
                    $detail['trade_name'] = $drugs->storage->drug->trade_name;
                }elseif(App::getLocale('ru')){
                    $detail['trade_name'] = $drugs->storage->drug->trade_name_ru;
                }elseif(App::getLocale('en')){
                    $detail['trade_name'] = $drugs->storage->drug->trade_name_en;
                }
                $detail['count'] = $drugs->count;
                $detail['price'] = $drugs->price;
                $details[] = $detail;
            }
            return response()->json(['details' => $details]);
        }
    }

    public function createMessage(Request $request){
        $data = $request->all();
        if(UserOrder::where('order',$data['order'])->where('id',$data['id'])->count()){
            $order = UserOrder::where('order',$data['order'])->where('id',$data['id'])->first();

            if(Auth::check() || (isset($data['user']) && $data['user'] == 'anonymus')){
                $from = 'user';
                $status = UserOrder::SENDED;
            }else{
                $from = 'pharmacy';
                $status = UserOrder::RESEND;
            }
            $message = UserOrderMessage::create(array(
                'user_order_id' => $data['id'],
                'from' => $from,
                'message' => $data['message']
            ));
            if($order->status != UserOrder::CANCELED && $order->status != UserOrder::CANCELEDBYUSER){
                UserOrder::where('order',$data['order'])->update(array(
                   'status' => $status
                ));
            }
            $data = array(
                'message' => $message->message,
                'date' => date("Y-m-d",strtotime($message->created_at . "+ 4 hour")),
                'from' => Lang::get('main.you')
            );
            return response()->json($data);
        }else{
            return response()->json(false);
        }
    }

    public function getMessages(Request $request){
        $data = $request->all();
        $messages = UserOrderMessage::where('user_order_id',$data['id'])->get();
        $user_order = UserOrder::where('id',$data['id'])->first();
        if(!$user_order){

            return response()->json(['error' => Lang::get('main.orderNotFound')]);
        }
        $from = 'pharmacy';
        if(!Auth::check()){
            $from = 'user';
        }
        UserOrderMessage::where('user_order_id',$data['id'])->where('from',$from)->update(array(
           'read' => 1
        ));
        $data = array();
        foreach($messages as $message){
            $data[] = array(
                'message' => $message->message,
                'date' => date("Y-m-d",strtotime($message->created_at . "+ 4 hour")),
                'from' => Lang::get('main.you')
            );
        }
        return response()->json(['messages' => $data,'order' => $user_order]);
    }

    public function pay(Request $request){
        $data = $request->all();
        $take_time = null;
        if(!empty($data['take_time'])){
            $take_time = $data['take_time'];
        }
        UserOrder::where('order',$data['order'])->update(array(
            'pay_method' => $data['method'],
            'pay_type' => $data['type'],
            'delivery_address' => $data['address'],
            'take_time' => $take_time,
            'unknown_user_name' => $data['unknown_user_name'],
            'unknown_user_phone' => $data['unknown_user_phone'],
        ));
        return response()->json(true);
    }

    public function info(Request $request){
        $data = $request->all();
        $drug = Storage::where('id',$data['id'])->first();
        $settings = json_decode($drug->drug_settings);
        $response_settings = array();
        foreach($settings as $key => $setting){
            foreach($drug->drug->$key as $drug_settings){
                if($drug_settings->id == $setting){
                    if(preg_match('/date/',$key)){
                        $response_settings[] = array("name" => $drug->drug->setting_names()[$key], "value" => $drug_settings->date);
                    }elseif(preg_match('/count/',$key) && $key != 'country'){
                        $response_settings[] = array("name" => $drug->drug->setting_names()[$key], "value" => $drug_settings->count);
                    }else{
                        $response_settings[] = array("name" => $drug->drug->setting_names()[$key], "value" => $drug_settings->name);
                    }
                }
            }
        }
        return response()->json($response_settings);
    }

    public function canceled(Request $request){
        $data = $request->all();
        if($data['status'] == 'canceled'){
            $status = UserOrder::CANCELEDBYUSER;
        }else{
            $status = UserOrder::CLOSEDBYUSER;
        }
        UserOrder::where('id',$data['id'])->update(array('status' => $status));
        return response()->json(true);
    }

    public function rank(Request $request){
        $data = $request->all();
        $order = UserOrder::find($data['id']);
        if(!$order->stars){
            $order->stars = $data['rating'];
            $order->save();
        }
        return response()->json(true);
    }
}
