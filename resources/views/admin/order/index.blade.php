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
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul class="list-group">
                                @foreach ($errors->all() as $error)
                                    <li class="list-group-item">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a id="sample_editable_1_new" href="/admin/order/create" class="btn green">
                                        {{Lang::get('admin_main.add_new')}}<i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover datatable">
                        <thead>
                        <tr>
                            <th>{{Lang::get('admin_main.to')}}</th>
                            <th>{{Lang::get('admin_main.from')}}</th>
                            <th>{{Lang::get('admin_main.status')}}</th>
                            <th>{{Lang::get('admin_main.delivery_status')}}</th>
                            <th>{{Lang::get('admin_main.created_at')}}</th>
                            <th>{{Lang::get('admin_main.actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <?php
                            $order_busy = \App\Models\OrderBusy::where('order_id',$order->id)->where('status',1)->first();
                            $order_unread_messages = 0;
                            ?>
                            @foreach($order->messages as $unread_messages)
                                @if(!$unread_messages->read && $unread_messages->from != Auth::guard('admin')->user()['id'])
                                <?php
                                    $order_unread_messages++;
                                ?>
                                @endif
                            @endforeach
                            <tr class="odd gradeX">
                                <td>{{$order->organizationTo->name}}</td>
                                <td>{{$order->organizationFrom->name}}</td>
                                <td>
                                    @if($order->organizationTo->id == Auth::guard('admin')->user()['organization_id'])
                                        {{$status[$order->status]}}
                                        @if($order_busy && $order_busy->admin_id != Auth::guard('admin')->user()['id'])
                                        @else
                                            @if($order->status != \App\Models\Order::APPROVED && $order->status != \App\Models\Order::RECEIVED && $order->status != \App\Models\Order::PROCEEDFROM)
                                            {!! Form::open(['id' => 'form_change_order_status','url' => '/admin/order/changeStatus']) !!}
                                            <input type="hidden" value="{{$order->id}}" name="id">
                                            <select class="form-control" name="status" id="order_table_status">
                                                <option value="0"></option>
                                                @foreach($status_to as $key => $value)
                                                    @if($status[$order->status] != $value)
                                                        <option value="{{$key}}">{{$value}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                            @endif
                                            {!! Form::close() !!}
                                        @endif
                                    @else
                                        {{$status[$order->status]}}
                                    @endif
                                </td>
                                <td>
                                    @if($order->delivery_status_id)
                                        {{$order->delivery_status->name}}
                                    @endif
                                </td>
                                <td>{{$order->created_at}}</td>
                                <td>

                                    @if($order_busy && $order_busy->admin_id != Auth::guard('admin')->user()['id'] && $order_busy->organization_id == Auth::guard('admin')->user()['organization_id'])
                                        This order already relased by {{$order_busy->admin->firstname ." ". $order_busy->admin->lastname}}
                                    @else
                                        @if(\App\Models\Order::CANCELED == $order->status && $order->from == Auth::guard("admin")->user()['organization_id'])
                                        <a href="#" class="view-messages" data-id="{{$order->id}}" title="View"><i class="fa fa-envelope"></i></a>
                                        @else
                                            @if($order->status != \App\Models\Order::APPROVED && $order->status != \App\Models\Order::RECEIVED)
                                                @if($order->from == Auth::guard("admin")->user()['organization_id'] && ($order->status == \App\Models\Order::PROCEEDFROM || $order->status == \App\Models\Order::SAVED))
                                                <a href="/admin/order/{{$order->id}}/edit" title="Edit"><i class="fa fa-pencil"></i></a>
                                                @elseif($order->to == Auth::guard("admin")->user()['organization_id'] && $order->status != \App\Models\Order::PROCEEDFROM)
                                                <a href="/admin/order/{{$order->id}}/edit" title="Edit"><i class="fa fa-pencil"></i></a>
                                                @endif
                                            @endif
                                            @if($order->status == \App\Models\Order::APPROVED && $order->status != \App\Models\Order::RECEIVED)
                                                @if($order->from == Auth::guard("admin")->user()['organization_id'])
                                                    {!! Form::open(['url' => '/admin/order/changeStatus/received']) !!}
                                                    <input type="hidden" name="order_id" value="{{$order->id}}">
                                                    <button class="btn blue received-order">Received</button>
                                                    {!! Form::close() !!}
                                                @endif
                                            @endif
                                            <a href="#" class="view-messages" data-id="{{$order->id}}" title="View">
                                                @if($order_unread_messages)
                                                <span style="color: red"><i class="fa fa-envelope" ></i> + {{$order_unread_messages}}</span>
                                                @else
                                                <i class="fa fa-envelope"></i>
                                                @endif
                                            </a>
                                            <a href="#" class="view-files" data-id="{{$order->id}}" title="Watch Files"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                                            @if($order->from == Auth::guard("admin")->user()['organization_id'] && !$order->status)
                                                {!! Form::open(['class' => 'storage-save-all']) !!}
                                                <button type="submit" data-count="0" data-id="{{$order->id}}" class="btn yellow save-all-storage order-send edit in_table"><i class="fa fa-check"></i>Send</button>
                                                {!! Form::close() !!}
                                            @endif
                                            @if($order_busy && $order_busy->admin_id == Auth::guard('admin')->user()['id'] && $order_busy->organization_id == Auth::guard('admin')->user()['organization_id'])
                                                <a class="btn btn-danger" href="/admin/order/release/{{$order->id}}">Release order</a>
                                            @endif
                                            @if($order->status != \App\Models\Order::APPROVED && $order->status != \App\Models\Order::RECEIVED)
                                                @if($order->to == Auth::guard('admin')->user()['organization_id'])

                                                    <button class="order-discount-button btn btn-warning" data-id="{{$order->id}}" data-pharmacy="{{$order->from}}">Order Discount</button>
                                                @endif
                                            @endif
                                        @endif
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
    <div id="view_order_message" class="modal fade small" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <div class="scroller" style="height:300px;overflow-y: auto" data-always-visible="1" data-rail-visible1="1">
                        <div class="row">
                            <div class="portlet light ">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="icon-bubble font-red-sunglo"></i>
                                        <span class="caption-subject font-red-sunglo bold uppercase">{{Lang::get('admin_main.messages')}}</span>
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
    <div id="change_order_status_to_modal" class="modal fade small" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">{{Lang::get('admin_main.change_status')}}</h4>
                </div>
                {!! Form::open(['id' => 'change_order_status_to']) !!}
                <div class="modal-body">
                    <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
                        <div class="row">
                            <div class=" col-md-12 change-order-status-to-date-block">

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <span class="error"></span>
                                <textarea class="change-order-status-to-message form-control" name="message" rows="10"></textarea>
                                <input type="hidden" name="status" id="status">
                                <input type="hidden" name="id" id="order_id">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn blue send-order-message-button">{{Lang::get('admin_main.send')}}</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div id="received_modal" class="modal fade small" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">{{Lang::get('admin_main.send')}}</h4>
                </div>
                <div class="modal-body">
                    <div class="scroller" style="height:300px;overflow-y: auto;" data-always-visible="1" data-rail-visible1="1">
                        <div class="row">
                            <div class=" col-md-12 order-files-block">
                                <table class="table table-striped table-bordered received-modal-list ">
                                    <thead>
                                        <tr>
                                            <th>{{Lang::get('admin_main.name')}}</th>
                                            <th>{{Lang::get('admin_main.count')}}</th>
                                            <th>{{Lang::get('admin_main.settings')}}</th>
                                            <th class="received-modal-price-field">{{Lang::get('admin_main.price_discounted')}}</th>
                                            <th>{{Lang::get('admin_main.procent')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <form>
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button type="button" class="btn btn-success received-order-modal">{{Lang::get('admin_main.received')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="view_order_files" class="modal fade small" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Files</h4>
                </div>
                <div class="modal-body">
                    <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
                        <div class="row">
                            <div class=" col-md-12 order-files-block">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="view_order_discount" class="modal fade small" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">{{Lang::get('admin_main.discount_order')}}</h4>
                </div>
                <form class="discount-form">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="pharmacy" value="">
                    <input type="hidden" name="order_id" value="">
                    <div class="modal-body">
                        <div class="scroller" data-always-visible="1" data-rail-visible1="1">
                            <div class="form-group">
                                <label>{{Lang::get('admin_main.discount_proceent')}}</label>
                                <input type="text" name="discount" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info">{{Lang::get('admin_main.save')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection