<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Order;
use App\Models\Message;
use App\Models\WatchMessage;
use Auth;

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

            $view->with(['orders'=>$orders,'status'=>$status,'unread_messages' => $unread_messages]);
        });
        return $next($request);
    }
}
