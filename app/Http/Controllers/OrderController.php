<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
class OrderController extends Controller
{
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

        print_r($request->all());die;
    }

    public function cart(){
        return view('cart');
    }
}
