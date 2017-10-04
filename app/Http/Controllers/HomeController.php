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
use App\Models\Storage;
use App\Models\UserOrderDetails;
use App\Models\TopRatedDrug;
use Illuminate\Support\Facades\Session;
use Location;
class HomeController extends Controller
{
    public function index(Request $request){
        $drugs = UserOrderDetails::select(DB::raw('sum(count) as count, storage_id'))
            ->groupBy('storage_id')->orderBy('count','DESC')->take(1)->get();
        $new_products = Storage::select(DB::raw('id,drug_id,price_id'))->orderBy('created_at','DESC')->take(3)->get();
        $top_rated = TopRatedDrug::orderBy('id','DESC')->take(3)->get();
        return view('home',['drugs' => $drugs,'new_products' => $new_products, 'top_rated' => $top_rated]);
    }

    public function account(){
        return view('account');
    }

    public function accountUpdate(Request $request,$id){
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|max:255|unique:users,email,'.$id,
            'phone' => 'required|numeric|digits_between:8,8|unique:users,email,'.$id,
        ]);
        $data = $request->all();
        User::where('id',$id)->update(array(
           'name' => $data['name'],
           'email' => $data['email'],
           'phone' => $data['phone'],
        ));
        return redirect('/account')->with(['success' => Lang::get('main.accountUpdate')]);
    }

    public function search(Request $request){
        $data = $request->all();
        $organization_id = null;
        $search = session('search');
        if(empty($data['search']) && empty($data['page'])){
           return redirect('/');
        }
        if(!empty($data['search'])){
            session(['search' => $data['search']]);
            $search = $data['search'];
        }

        $drugs = DB::select('Call search("'.$search.'")');
        return view('search',['drugs' => $drugs,'organization_id' => $organization_id]);
    }

    public function searchByOrg(Request $request,$organization_id){
        $data = $request->all();
        $request->session()->forget('search');
        if(!empty($data)){
            $storage = Storage::whereHas('drug', function ($q) use($data) {
                $q->where('trade_name', 'like', "%".$data['search']."%")
                    ->orWhere('trade_name_ru','like',"%".$data['search']."%")
                    ->orWhere('trade_name_en','like',"%".$data['search']."%")
                    ->orWhere('code',$data['search']);
            })->where('organization_id',$organization_id)->get();

        }else{
            $storage = Storage::where('organization_id',$organization_id)->get();
        }
        $organization = Organization::where('id',$organization_id)->first();
        $drugs = array();
        foreach($storage as $value){
            $row = new \stdClass();
            $row->trade_name = $value->drug->trade_name;
            $row->trade_name_ru = $value->drug->trade_name_ru;
            $row->trade_name_en = $value->drug->trade_name_en;
            $row->drug_settings = $value->drug_settings;
            $row->storage_id = $value->id;
            $row->id = $value->organization->id;
            $row->name = $value->organization->name;
            $row->address = $value->organization->city." ".$value->organization->street." ".$value->organization->apartment;
            $row->phone = $value->organization->phone;
            $row->count = $value->count;
            $row->price = $value->price->price;
            $drugs[] = $row;
        }
        return view('search',['drugs' => $drugs,'organization_id' => $organization_id,'organization' => $organization]);
    }

    public function contact(){
        return view('contacts');
    }
    
    public function createTicket(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required|min:10',
        ]);
        $data = $request->all();
        App\Models\Tiket::create(array(
            'name' => $data['name'],
            'email' => $data['email'],
            'message' => $data['message']
        ));
        return redirect('/')->with('ticket', 'Your Ticket Created Successfully');
    }
}
