@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box grey-cascade">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-user"></i>{{Lang::get('admin_main.manage_roles')}}
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
                                    <a id="sample_editable_1_new" href="/admin/manage/roles/create" class="btn green">
                                        {{Lang::get('admin_main.add_new')}} <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>
                                {{Lang::get('admin_main.name')}}
                            </th>
                            <th>
                                {{Lang::get('admin_main.created_at')}}
                            </th>
                            <th>
                                {{Lang::get('admin_main.actions')}}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr class="odd gradeX">
                                <td>{{$role->name}}</td>
                                <td>{{$role->created_at}}</td>
                                <td>
                                    @if($role->id != 1 && $role->name != 'admin')
                                        {!! Form::open(['url' => 'admin/manage/roles/'.$role->id, 'method' => 'DELETE', 'class' => 'delete-form']) !!}
                                        <a href="/admin/manage/roles/{{$role->id}}/edit" title="Edit"><i class="fa fa-pencil"></i></a>
                                        <button title="Delete" type="submit"><i class="fa fa-remove"></i></button>
                                        {!! Form::close() !!}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection