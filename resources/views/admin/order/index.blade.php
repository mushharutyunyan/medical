@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box grey-cascade">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-user"></i>Orders  ({{Auth::guard('admin')->user()->organization->name}})
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
                                        Add New <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>
                                To
                            </th>
                            <th>
                                From
                            </th>
                            <th>
                                File
                            </th>
                            <th>
                                Status
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
                        @foreach($orders as $order)

                            <tr class="odd gradeX">
                                @if($order->to == Auth::user())
                                <td>{{$order->drug->trade_name}}</td>
                                <td>{{$storage->count}}</td>
                                <td>{{$storage->created_at}}</td>
                                <td>
                                    <a href="/admin/storage/{{$storage->id}}/edit" title="Edit"><i class="fa fa-pencil"></i></a>
                                    <a href="#" class="view-edit-drug view" data-id="{{$storage->id}}" title="View"><i class="fa fa-eye"></i></a>
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
    <div id="edit_view_drug" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"><h4 class="modal-title">View Drug</h4></h4>
                </div>
                <div class="modal-body">

                    <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="drug-name">

                                </h4>
                            </div>
                        </div>
                        <div class="row drug-content">

                        </div>

                        <div class="row drug-settings">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered table-hover drug-settings-view-table" style="margin-top: 10px;">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Info</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection