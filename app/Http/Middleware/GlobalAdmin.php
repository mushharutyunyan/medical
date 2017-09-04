<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Order;
use App\Models\Message;
use App\Models\WatchMessage;
use Auth;
use App\Models\UserOrder;
use App\Models\UserOrderMessage;
use Lang;
class GlobalAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!Auth::guard('admin')->check()){
            return redirect('/admin/login');
        }
        view()->composer('layouts.admin', function($view) {
            $orders = Order::where('from',Auth::guard('admin')->user()['organization_id'])->whereIn('status',array(Order::PROCEEDFROM,Order::APPROVED))->orWhere('to',Auth::guard('admin')->user()['organization_id'])->where('status',Order::PROCEEDTO)->get();
            $status = Order::$status;


            $messages = Message::where('to',Auth::guard('admin')->user()['id'])->get();
            $unread_messages = array();
            foreach ($messages as $message){
                $watch_messages = WatchMessage::where('admin_id',Auth::guard('admin')->user()['id'])->where('partner_id',$message->from)->first();
                if($watch_messages){
                    if(strtotime($message->created_at) > strtotime($watch_messages->updated_at)){
                        $unread_messages[] = $message;
                    }
                }else{
                    $unread_messages[] = $message;
                }
            }

            $userOrders = UserOrder::where('status',UserOrder::SENDED)
                ->orWhere('status',UserOrder::CANCELEDBYUSER)
                ->orWhere('status',UserOrder::CLOSEDBYUSER)
                ->orWhere('status',UserOrder::APPROVED)
                ->where('pay_method','!=',null)->get();
            $user_notifications = array();
            foreach ($userOrders as $order){
                if(Auth::guard('admin')->user()['organization_id'] != $order->organization_id){
                    continue;
                }
                $unread_messages_count = UserOrderMessage::where('user_order_id',$order->id)->where('read',0)->where('from','user')->count();
                $message = Lang::get('main.orderStatusText',['status' => Lang::get('main.'.UserOrder::$status[$order->status])]);
                if($unread_messages_count){
                    $message .= ", ".Lang::get('main.orderMessageText',['count' => $unread_messages_count]);
                }
                $user_notifications[] = array(
                    'name' => $order->order,
                    'message' => $message,
                    'datetime' => $order->updated_at
                );
            }
            $view->with(['orders'=>$orders,'status'=>$status,'unread_messages' => $unread_messages,'user_notifications' => $user_notifications]);
        });
        return $next($request);
    }
}
