<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use App\Models\Organization;
use App\Models\AdminOrganization;
use App\Http\Requests\AdminsRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::guard('admin')->user()->role->id != 1){
            $admin_organizations = Auth::guard('admin')->user()->admin_organizations()->get();
            $admins = '';
        }else{
            $admins = Admin::all();
            $admin_organizations = '';
        }
        return view('admin.manage.admins.index',['admin_organizations' => $admin_organizations, 'admins' => $admins]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::guard('admin')->user()->role->id != 1){
            $roles = Role::where('id','!=',1)->where('name','!=','admin')->get();
        }else{
            $roles = Role::where('id',1)->orWhere('name','admin')->get();
        }
        if(Auth::guard('admin')->user()->role->id != 1){
            $admin_organizations = Auth::guard('admin')->user()->admin_organizations()->get();
            $organization_ids = array();
            foreach($admin_organizations as $organization){
                $organization_ids[] = $organization->organization_id;
            }
            $organizations = Organization::whereIn('id',$organization_ids)->get();
        }else{
            $organizations = Organization::all();
        }
        return view('admin.manage.admins.create',['roles' => $roles, 'organizations' => $organizations]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminsRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $created = Admin::create($data);
        if($data['role_id'] >= 2){
            AdminOrganization::create(array(
                'admin_id' => $created->id,
                'organization_id' => $data['organization_id']
            ));
        }
        return redirect('admin/manage/admins')->with('status', 'Admin profile created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::guard('admin')->user()->role->id != 1){
            $roles = Role::where('id','!=',1)->where('name','!=','admin')->get();
        }else{
            $roles = Role::All();
        }
        $organizations = Organization::all();
        $currentAdmin = Admin::where('id',$id)->first();
        return view('admin.manage.admins.edit',['currentAdmin' => $currentAdmin,'roles' => $roles, 'organizations' => $organizations]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminsRequest $request, $id)
    {
        $data = $request->all();
        if($data['_method'] == 'PATCH'){
            Admin::where('id',$id)->update(array('password' => bcrypt($data['password'])));
            $message = 'Admin profile password updated successfully';
        }else{
            Admin::where('id',$id)->update(array('organization_id' => $data['organization_id'],
                                           'role_id' => $data['role_id'],
                                           'firstname' => $data['firstname'],
                                           'lastname' => $data['lastname'],
                                           'email' => $data['email']));
            $message = 'Admin profile updated successfully';
        }
        return redirect('admin/manage/admins')->with('status', $message);
    }

    public function changePassword($id){
        $currentAdmin = Admin::where('id',$id)->first();
        return view('admin.manage.admins.editPassword',compact('currentAdmin'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Admin::where('id',$id)->delete();
        return redirect('admin/manage/admins')->with('status', 'Admin profile deleted successfully');
    }
}
