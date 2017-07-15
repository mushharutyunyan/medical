<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use URL;
class RolesController extends Controller
{

    public function __construct() {
        $this->middleware('superAdmin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('admin.manage.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.manage.roles.create');
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
            'name' => 'required|unique:roles,name',
        ]);
        unset($data['redirect_url']);
        Role::create($request->all());

        return redirect($redirect_uri)->with('status', 'New Role created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $currentRole = Role::where('id',$id)->first();
        return view('admin.manage.roles.edit',compact('currentRole'));
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
            'name' => 'required|unique:roles,name,'.$id,
        ]);
        $data = $request->all();
        Role::where('id',$id)->update(array('name' => $data['name']));
        return redirect('admin/manage/roles')->with('status', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Role::where('id',$id)->delete();
        return redirect('admin/manage/roles')->with('status', 'Role deleted successfully');
    }
}
