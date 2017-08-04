<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Image;
use Input;
class OrganizationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organizations = Organization::all();
        $status = Organization::STATUS;
        return view('admin.manage.organizations.index',['status' => $status, 'organizations' => $organizations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $status = Organization::STATUS;
        return view('admin.manage.organizations.create',['status' => $status]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $redirect_uri = $data['redirect_url'];
        $this->validate($request, [
            'name' => 'required|unique:organizations,name',
        ]);
        $data['admin_id'] = Auth::guard('admin')->user()['id'];
        if(isset($data['picture'])){
            $picture = $data['picture'];
            $name  = time() . '.' . $picture->getClientOriginalExtension();
            $path = public_path('assets/admin/images/organizations/' . $name);
            Image::make($picture->getRealPath())->resize(320, 240)->save($path);
            $data['image'] = $name;
        }
        unset($data['redirect_url']);
        Organization::create($data);
        return redirect($redirect_uri)->with('status', 'New Organizations created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $status = Organization::STATUS;
        $currentOrganization = Organization::where('id',$id)->first();
        return view('admin.manage.organizations.edit',['status' => $status, 'currentOrganization' => $currentOrganization]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:organizations,name,'.$id,
        ]);
        $data = $request->all();
        unset($data['_method']);
        unset($data['_token']);
        Organization::where('id',$id)->update($data);
        return redirect('admin/manage/organizations')->with('status', 'Organization updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Organization::where('id',$id)->delete();
        return redirect('admin/manage/organizations')->with('status', 'Organization deleted successfully');
    }
}
