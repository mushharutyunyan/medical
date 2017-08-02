<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Lang;

class HomeController extends Controller
{
    public function index(){
        return view('home');
    }

    public function account(){
        return view('account');
    }

    public function accountUpdate(Request $request,$id){
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,'.$id,
        ]);
        $data = $request->all();
        User::where('id',$id)->update(array(
           'name' => $data['name'],
           'email' => $data['email'],
        ));
        return redirect('/account')->with(['success' => Lang::get('main.accountUpdate')]);
    }
}
