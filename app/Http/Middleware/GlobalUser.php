<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Models\UserOrder;
use App\Models\UserOrderMessage;
use Illuminate\Support\Facades\Lang;

class GlobalUser
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
        if(Auth::check()){
            view()->composer('layouts.main', function($view) {
                $orders = UserOrder::where('status',UserOrder::RESEND)
                    ->orWhere('status',UserOrder::APPROVED)
                    ->where('pay_method',null)->get();
                $messages = array();
                foreach ($orders as $order){
                    if(Auth::user()['id'] != $order->user_id){
                        continue;
                    }
                    $unread_messages_count = UserOrderMessage::where('user_order_id',$order->id)->where('read',0)->where('from','pharmacy')->count();
                    $message = Lang::get('main.orderStatusText',['status' => Lang::get('main.'.UserOrder::$status[$order->status])]);
                    if($unread_messages_count){
                        $message .= ", ".Lang::get('main.orderMessageText',['count' => $unread_messages_count]);
                    }
                    $messages[] = array(
                        'name' => $order->order." (".$order->organization->name.")",
                        'message' => $message
                    );
                }

                $view->with(['messages' => $messages]);
            });
        }
        return $next($request);
    }
}
