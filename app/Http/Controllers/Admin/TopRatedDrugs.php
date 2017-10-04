<?php

namespace App\Http\Controllers\Admin;

use App\Models\Organization;
use App\Models\Storage;
use App\Models\TopRatedDrug;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class TopRatedDrugs extends Controller
{
    public function index(){
        $tops = TopRatedDrug::all();
        return view('admin.manage.topRated.index',['tops' => $tops]);
    }

    public function create(){
        $organizations = Organization::where('status','>',1)->get();
        return view('admin.manage.topRated.create',['organizations' => $organizations]);
    }

    public function show(Request $request){
        $data = $request->all();
        $storage = Storage::where('organization_id',$data['organization_id'])->get();
        $response = array();
        foreach($storage as $drugs){
            $response[] = array(
                'id' => $drugs->id,
                'name' => $drugs->drug->trade_name,
                'price' => $drugs->price->price
            );
        }
        return response()->json($response);
    }

    public function store(Request $request){

        $this->validate($request, [
            'storage_id' => 'required',
        ]);
        $data = $request->all();
        TopRatedDrug::create(array(
            'storage_id' => $data['storage_id']
        ));
        return redirect('/admin/manage/topRated')->with('status', 'New Top Rated Drug created successfully');
    }

    public function destroy($id)
    {
        TopRatedDrug::where('id',$id)->delete();
        return redirect('admin/manage/topRated')->with('status', 'Top Rated Drug deleted successfully');
    }
}
