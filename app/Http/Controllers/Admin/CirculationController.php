<?php

namespace App\Http\Controllers\Admin;

use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\UserOrder;
use Illuminate\Support\Facades\Auth;

class CirculationController extends Controller
{
    public function index(){
        if(Auth::guard('admin')->user()['id'] == 1){// SuperAdmin
            $user_orders = UserOrder::where('status',10)->get();
            $orders = Order::where('status',5)->get();
        }
        return view('admin.manage.circulation.index',['user_orders' => $user_orders,'orders' => $orders]);
//        if(Auth::guard('admin')->user()->organization->status == Organization::WHOLESALE){
//
//        }
    }
}
