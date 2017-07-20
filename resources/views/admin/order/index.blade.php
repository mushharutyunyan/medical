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
                                    <a id="sample_editable_1_new" href="/admin/order/create" class="btn green">
                                        Add New <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover datatable">
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
                                <td>{{$order->organizationTo->name}}</td>
                                <td>{{$order->organizationFrom->name}}</td>
                                <td>{{$order->file}}</td>
                                <td>{{$status[$order->status]}}</td>
                                <td>{{$order->created_at}}</td>
                                <td>
                                    <a href="/admin/order/{{$order->id}}/edit" title="Edit"><i class="fa fa-pencil"></i></a>
                                    <a href="#" class="view-edit-order view" data-id="{{$order->id}}" title="View"><i class="fa fa-eye"></i></a>
                                    <a href="#" class="view-messages" data-id="{{$order->id}}" title="View"><i class="fa fa-envelope"></i></a>
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
    <div id="view_order_message" class="modal fade small" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
                        <div class="row">
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-bubble font-red-sunglo"></i>
                                        <span class="caption-subject font-red-sunglo bold uppercase">Messages</span>
                                    </div>
                                </div>
                                <div class="portlet-body" id="chats">
                                    <div class="scroller" style="height: 353px;" data-always-visible="1" data-rail-visible1="1">
                                        <ul class="chats">
                                            <li class="in">
                                                <img class="avatar" alt="" src="/assets/admin/img/avatar.png"/>
                                                <div class="message">
												<span class="arrow">
												</span>
                                                    <a href="#" class="name">Bob Nilson </a><span class="datetime">at 20:09 </span><span class="body"></span>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    {{--<div class="chat-form">--}}
                                        {{--<div class="input-cont">--}}
                                            {{--<input class="form-control" type="text" placeholder="Type a message here..."/>--}}
                                        {{--</div>--}}
                                        {{--<div class="btn-cont">--}}
										{{--<span class="arrow">--}}
										{{--</span>--}}
                                            {{--<a href="" class="btn blue icn-only">--}}
                                                {{--<i class="fa fa-check icon-white"></i>--}}
                                            {{--</a>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection