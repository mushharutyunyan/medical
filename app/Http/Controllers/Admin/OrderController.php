<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::where('to',Auth::guard('admin')->user()['organization_id'])->orWhere('from',Auth::guard('admin')->user()['organization_id'])->get();
        return view('admin.order.index',compact('orders'));
    }
}
