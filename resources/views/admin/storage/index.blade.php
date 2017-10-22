@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box grey-cascade">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-user"></i>{{Lang::get('admin_main.manage_storage')}} ({{$organization_name}})
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
                                    <a id="sample_editable_1_new" href="/admin/storage/create" class="btn green">
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
                                {{Lang::get('admin_main.drug')}}
                            </th>
                            <th>
                                {{Lang::get('admin_main.price')}}
                            </th>
                            <th>
                                {{Lang::get('admin_main.count')}}
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
                        @foreach($storages as $storage)

                            <tr class="odd gradeX">
                                <td>{{$storage->drug->trade_name}}</td>
                                <td>{{$storage->price->price}}</td>
                                <td>{{$storage->count}}</td>
                                <td>{{$storage->updated_at}}</td>
                                <td>
                                    <a href="/admin/storage/{{$storage->id}}/edit" title="Edit"><i class="fa fa-pencil"></i></a>
                                    <a href="#" class="view-edit-drug view" data-storage-id="{{$storage->id}}" title="View"><i class="fa fa-eye"></i></a>
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