@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box grey-cascade">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-user"></i> {{Lang::get('admin_main.manage_storage_list_organizations')}}
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
                        @foreach($admin_organizations as $organization)

                            <tr class="odd gradeX">
                                <td>{{$organization->organization->name}}</td>
                                <td>{{$organization->organization->director}}</td>
                                <td>{{$organization->organization->email}}</td>
                                <td>{{$organization->organization->city}} {{$organization->organization->street}} {{$organization->organization->apartment}}</td>
                                <td>{{$organization->organization->phone}}</td>
                                <td>
                                    @if($organization->organization->status)
                                        {{$status[$organization->organization->status]}}
                                    @endif
                                </td>
                                <td>{{$organization->organization->created_at}}</td>
                                <td>
                                    <a href="/admin/storage/{{$organization->organization->id}}"><i class="fa fa-eye"></i></a>
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