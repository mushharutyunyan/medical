<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use App;
use App\Models\Drug;
use App\Models\Organization;
use Illuminate\Support\Facades\Session;

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

    public function search(Request $request){
        $data = $request->all();
        $search = session('search');
        if(empty($data['search']) && empty($data['page'])){
           return redirect('/');
        }
        if(!empty($data['search'])){
            session(['search' => $data['search']]);
            $search = $data['search'];
        }

        $drugs = DB::select('Call search("'.$search.'")');
        return view('search',['drugs' => $drugs]);
    }
}
