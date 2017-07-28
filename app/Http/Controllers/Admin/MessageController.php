<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Message;
use App\Models\WatchMessage;
use Illuminate\Support\Facades\Auth;
class MessageController extends Controller
{
    public function index(){
        $admins = Admin::where('id','!=',Auth::guard('admin')->user()['id'])->get();
        return view('admin.message.index',['admins' => $admins,'id' => '']);
    }

    public function show(Request $request,$id){
        if(WatchMessage::where('admin_id',Auth::guard('admin')->user()['id'])->where('partner_id',$id)->count()){
            WatchMessage::where('admin_id',Auth::guard('admin')->user()['id'])->where('partner_id',$id)
                ->update(array(
                   'partner_id' => $id
                ));// just for check header messages tab
        }else{
            WatchMessage::create(array(
               'admin_id' => Auth::guard('admin')->user()['id'],
                'partner_id' => $id
            ));
        }
        $messages = Message::where('to',Auth::guard('admin')->user()['id'])->where('from',$id)->orWhere('from',Auth::guard('admin')->user()['id'])->where('to',$id)->get();
        if($request->ajax()){
            return response()->json($messages);
        }else{
            $admins = Admin::where('id','!=',Auth::guard('admin')->user()['id'])->get();
            return view('admin.message.index',['admins' => $admins,'messages' => $messages,'id' => $id]);
        }
    }

    public function store(Request $request){
        $data = $request->all();
        Message::create(array(
           'to' => $data['to'],
            'from' => Auth::guard('admin')->user()['id'],
            'message' => $data['message']
        ));
        return response()->json(true);
    }
}
