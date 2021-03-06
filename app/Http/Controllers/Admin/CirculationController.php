<?php

namespace App\Http\Controllers\Admin;

use App\Models\AdminOrganization;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\UserOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class CirculationController extends Controller
{
    public function index(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            if(isset($data['circulation_users']) || isset($data['user_order_organizations'])){

                if(!empty($data['circulation_users'])){
                    if(!empty($data['user_order_organizations'])){
                        $user_orders = UserOrder::where('status',10)->where('user_id',$data['circulation_users'])->where('organization_id',$data['user_order_organizations'])->get();
                    }else{
                        $user_orders = UserOrder::where('status',10)->where('user_id',$data['circulation_users'])->get();
                    }
                }elseif(!empty($data['user_order_organizations'])){
                    $user_orders = UserOrder::where('status',10)->where('organization_id',$data['user_order_organizations'])->get();
                }else{
                    $user_orders = UserOrder::where('status',10)->get();
                }

                $users = UserOrder::where('status',10)->get()->unique('user_id');
                $user_order_organizations = UserOrder::where('status',10)->get()->unique('organization_id');
                $orders = Order::where('status',5)->get();
            }elseif(isset($data['circulation_order_whole_sale']) || isset($data['circulation_order_pharmacy'])){
                $user_orders = UserOrder::where('status',10)->get();
                $users = $user_orders->unique('user_id');
                $user_order_organizations = $user_orders->unique('organization_id');

                if(!empty($data['circulation_order_whole_sale'])){
                    if(!empty($data['circulation_order_pharmacy'])){
                        $orders = Order::where('status',5)->where('to',$data['circulation_order_whole_sale'])->where('from',$data['circulation_order_pharmacy'])->get();
                    }else{
                        $orders = Order::where('status',5)->where('to',$data['circulation_order_whole_sale'])->get();
                    }
                }elseif(!empty($data['circulation_order_pharmacy'])){
                    $orders = Order::where('status',5)->where('from',$data['circulation_order_pharmacy'])->get();
                }else{
                    $orders = Order::where('status',5)->get();

                }
            }
            $organizations = Organization::all();
        }else{
            $data = array();
            if(Auth::guard('admin')->user()['role_id'] == 1){// SuperAdmin
                $user_orders = UserOrder::where('status',10)->get();
                $users = $user_orders->unique('user_id');
                $user_order_organizations = $user_orders->unique('organization_id');
                $orders = Order::where('status',5)->get();
                $organizations = Organization::all();
            }else{
                $users = array();
                $organizations = array();
                $user_order_organizations = array();
                $organizations = AdminOrganization::where('admin_id',Auth::guard('admin')->user()['id'])->get();
                $organizationIds = array();
                foreach($organizations as $organization){
                    $organizationIds[] = $organization->organization_id;
                }
                $user_orders = UserOrder::where('status',10)->whereIn('organization_id',$organizationIds)->get();
                $orders = Order::where('status',5)->whereIn('to',$organizationIds)->orWhereIn('from',$organizationIds)->get();
            }
        }
        return view('admin.manage.circulation.index',[
            'user_orders' => $user_orders,
            'orders' => $orders,
            'users' => $users,
            'organizations' => $organizations,
            'data' => $data,
            'user_order_organizations' => $user_order_organizations
        ]);
//        if(Auth::guard('admin')->user()->organization->status == Organization::WHOLESALE){
//
//        }
    }
}
