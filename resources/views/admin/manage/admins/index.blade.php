@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box grey-cascade">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-user"></i>Managed Admins
                    </div>
                </div>
                <div class="portlet-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a id="sample_editable_1_new" href="/admin/manage/admins/create" class="btn green">
                                        Add New <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            {{--<div class="col-md-6">--}}
                                {{--<div class="btn-group pull-right">--}}
                                    {{--<button class="btn dropdown-toggle" data-toggle="dropdown">Tools <i class="fa fa-angle-down"></i>--}}
                                    {{--</button>--}}
                                    {{--<ul class="dropdown-menu pull-right">--}}
                                        {{--<li>--}}
                                            {{--<a href="#">--}}
                                                {{--Print </a>--}}
                                        {{--</li>--}}
                                        {{--<li>--}}
                                            {{--<a href="#">--}}
                                                {{--Save as PDF </a>--}}
                                        {{--</li>--}}
                                        {{--<li>--}}
                                            {{--<a href="#">--}}
                                                {{--Export to Excel </a>--}}
                                        {{--</li>--}}
                                    {{--</ul>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover datatable">
                        <thead>
                        <tr>
                            {{--<th class="table-checkbox">--}}
                                {{--<input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes"/>--}}
                            {{--</th>--}}
                            <th>
                                Role
                            </th>
                            <th>
                                Organization
                            </th>
                            <th>
                                Name
                            </th>
                            <th>
                                Username
                            </th>
                            <th>
                                Created At
                            </th>
                            <th>
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(!empty($admin_organizations))
                            @foreach($admin_organizations as $admin_organization)
                                @foreach($admin_organization->admin as $admin)
                                    @if(Auth::guard('admin')->user()['id'] != $admin->id)
                                        <tr class="odd gradeX">
                                            <td>{{$admin->role->name}}</td>
                                            <td>{{$admin->organization->name}}</td>
                                            <td>{{$admin->firstname}} {{$admin->lastname}}</td>
                                            <td>{{$admin->email}}</td>
                                            <td>{{$admin->created_at}}</td>
                                            <td>
                                                @if($admin->id != 1)
                                                    {!! Form::open(['url' => 'admin/manage/admins/'.$admin->id, 'method' => 'DELETE', 'class' => 'delete-form']) !!}
                                                    <a href="/admin/manage/admins/{{$admin->id}}/edit" title="Edit"><i class="fa fa-pencil"></i></a>
                                                    <a href="/admin/manage/admins/{{$admin->id}}/changePassword" title="Change Password"><i class="fa fa-cogs"></i></a>
                                                    <button title="Delete" type="submit"><i class="fa fa-remove"></i></button>
                                                    {!! Form::close() !!}
                                                @else
                                                    <a href="/admin/manage/admins/{{$admin->id}}/edit" title="Edit"><i class="fa fa-pencil"></i></a>
                                                    <a href="/admin/manage/admins/{{$admin->id}}/changePassword" title="Change Password"><i class="fa fa-cogs"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        @elseif(!empty($admins))
                            @foreach($admins as $admin)
                                <tr class="odd gradeX">
                                    <td>{{$admin->role->name}}</td>
                                    <td>{{$admin->organization->name}}</td>
                                    <td>{{$admin->firstname}} {{$admin->lastname}}</td>
                                    <td>{{$admin->email}}</td>
                                    <td>{{$admin->created_at}}</td>
                                    <td>
                                        @if($admin->id != 1)
                                            {!! Form::open(['url' => 'admin/manage/admins/'.$admin->id, 'method' => 'DELETE', 'class' => 'delete-form']) !!}
                                            <a href="/admin/manage/admins/{{$admin->id}}/edit" title="Edit"><i class="fa fa-pencil"></i></a>
                                            <a href="/admin/manage/admins/{{$admin->id}}/changePassword" title="Change Password"><i class="fa fa-cogs"></i></a>
                                            <button title="Delete" type="submit"><i class="fa fa-remove"></i></button>
                                            {!! Form::close() !!}
                                        @else
                                            <a href="/admin/manage/admins/{{$admin->id}}/edit" title="Edit"><i class="fa fa-pencil"></i></a>
                                            <a href="/admin/manage/admins/{{$admin->id}}/changePassword" title="Change Password"><i class="fa fa-cogs"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection