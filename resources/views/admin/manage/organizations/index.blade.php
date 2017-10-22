@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box grey-cascade">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-user"></i>{{Lang::get('admin_main.manage_organizations')}}
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
                                    <a id="sample_editable_1_new" href="/admin/manage/organizations/create" class="btn green">
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
                                {{Lang::get('admin_main.director')}}
                            </th>
                            <th>
                                {{Lang::get('admin_main.email')}}
                            </th>
                            <th>
                                {{Lang::get('admin_main.address')}}
                            </th>
                            <th>
                                {{Lang::get('admin_main.phone')}}
                            </th>
                            <th>
                                {{Lang::get('admin_main.status')}}
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
                        @foreach($organizations as $organization)

                            <tr class="odd gradeX">
                                <td>{{$organization->name}}</td>
                                <td>{{$organization->director}}</td>
                                <td>{{$organization->email}}</td>
                                <td>{{$organization->city}} {{$organization->street}} {{$organization->apartment}}</td>
                                <td>{{$organization->phone}}</td>
                                <td>
                                    @if($organization->status)
                                    {{$status[$organization->status]}}
                                    @endif
                                </td>
                                <td>{{$organization->created_at}}</td>
                                <td>
                                    <a href="/admin/manage/organizations/{{$organization->id}}/edit" title="Edit"><i class="fa fa-pencil"></i></a>
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