@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box grey-cascade">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-user"></i>User Orders
                    </div>
                </div>
                <div class="portlet-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table datatable table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Order (Status)</th>
                            <th>User Info</th>
                            <th>Pay method ,  Pay type</th>
                            <th>Delivery address / Take time</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)

                        <?php
                            $count_unread_messages = \App\Models\UserOrderMessage::where('user_order_id',$order->id)->where('read',0)->where('from','user')->count();
                            $order_busy = \App\Models\UserOrderBusy::where('user_order_id',$order->id)->where('status',1)->first();
                        ?>
                            <tr style="text-align: left">
                                <td>{{$order->order}} ({{Lang::get('main.'.\App\Models\UserOrder::$status[$order->status])}})</td>
                                @if($order->user)
                                <td>{{$order->user->name}} {{$order->user->email}} {{$order->user->phone}}</td>
                                @else
                                <td>{{$order->unknown_user_name}} {{$order->unknown_user_email}} {{$order->unknown_user_phone}}</td>
                                @endif
                                <td>{{$order->pay_method ? \App\Models\UserOrder::$pay_methods[$order->pay_method] : ''}} , {{$order->pay_type ? \App\Models\UserOrder::$pay_types[$order->pay_type] : ''}}</td>
                                @if($order->pay_type == \App\Models\UserOrder::DELIVERY)
                                <td class="pay_type">{{$order->delivery_address}}</td>
                                @else
                                <td class="pay_type">{{$order->take_time}}</td>
                                @endif
                                <td>{{$order->created_at}}</td>
                                <td>
                                    @if($order_busy && $order_busy->admin_id != Auth::guard('admin')->user()['id'] && $order_busy->organization_id == Auth::guard('admin')->user()['organization_id'])
                                        This order already take by another user
                                    @else
                                        @if($order->status != \App\Models\UserOrder::DELIVERED)
                                            @if($order->status == \App\Models\UserOrder::APPROVED && empty($order->pay_method))
                                                <a href="/admin/userOrder/{{$order->id}}/5" class="cancel-order">Cancel</a>
                                                <a href="/admin/userOrder/{{$order->id}}/4" class="cancel-order">Close</a>
                                            @else
                                            @if($order->status != \App\Models\UserOrder::CLOSED && $order->status != \App\Models\UserOrder::CANCELED)
                                                @if(empty($order->pay_method))
                                                    <a href="/admin/userOrder/{{$order->id}}/edit">Edit</a>
                                                    <a href="/admin/userOrder/{{$order->id}}/3" class="approved-order">Approved</a>
                                                    <a href="/admin/userOrder/{{$order->id}}/5" class="cancel-order">Cancel</a>
                                                @else
                                                    @if($order->status < \App\Models\UserOrder::APPROVEDBYPHARMACY)
                                                        <a href="#" style="color: green;" data-id="{{$order->id}}" class="finish-order">Edit(Approved)</a>
                                                    @else
                                                        <a href="javascript:;" class="finished_delivery" data-id="{{$order->id}}" style="color: green;">Delivery</a>
                                                    @endif
                                                @endif
                                                    <a href="/admin/userOrder/{{$order->id}}/4" class="cancel-order">Close</a>
                                            @endif
                                            @endif
                                        @endif
                                        <a href="javascript:;" data-id="{{$order->id}}" data-token="{{csrf_token()}}" class="show-order-details-history">{{Lang::get('main.details')}}</a>
                                        <a href="javascript:;" data-id="{{$order->id}}" data-token="{{csrf_token()}}" class="show-order-details-messages">{{Lang::get('main.messages')}}
                                            @if($count_unread_messages)
                                                <span style="color:red">({{$count_unread_messages}})</span>
                                            @endif
                                        </a>
                                    @endif
                                    @if($order_busy && $order_busy->admin_id == Auth::guard('admin')->user()['id'] && $order_busy->organization_id == Auth::guard('admin')->user()['organization_id'])
                                        <a class="btn btn-danger" href="/admin/userOrder/release/{{$order->id}}">Release order</a>
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
    <div id="showOrderDetailsModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{Lang::get('main.orderDetails')}}</h4>
                </div>
                <table class="table table-striped order-details-modal-table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Count</th>
                        <th>Price</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <div id="showOrderMessagesModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{Lang::get('main.messages')}}</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group chat">

                    </div>
                </div>
                <div class="modal-footer">
                    <form action="/order/createMessage" method="POST" class="add-order-message">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <div class="col-sm-10">
                            <input type="text" name="message" id="message" placeholder="{{Lang::get('main.enterTextMessage')}}" class="form-control">
                            <input type="hidden" value="" name="order">
                            <input type="hidden" value="" name="id">
                        </div>
                        <div class="col-sm-2">
                            <button class="btn btn-default pull-right">{{Lang::get('main.send')}}</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
    <div id="userOrderFinish" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Order Finish</h4>
                </div>
                <form id="order_finish_form">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="modal-body">
                            <select class="form-control" name="pay_type">
                                @foreach(\App\Models\UserOrder::$pay_types as $key => $type)
                                <option value="{{$key}}">{{$type}}</option>
                                @endforeach
                            </select>
                            <input type="text" class="form-control" name="take_time">
                            <input type="hidden" class="form-control" name="order_id">
                            <input type="text" class="form-control" name="delivery_address">
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success">Finish</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection