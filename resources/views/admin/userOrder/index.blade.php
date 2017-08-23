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
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>
                                Order
                            </th>
                            <th>
                                Status
                            </th>
                            <th>
                                Pay method
                            </th>
                            <th>
                                Pay type
                            </th>
                            <th>
                                Delivery address / Take time
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
                        <?php
                            $count_unread_messages = \App\Models\UserOrderMessage::where('user_order_id',$order->id)->where('read',0)->where('from','user')->count();
                        ?>
                            <tr style="text-align: left">
                                <td>{{$order->order}}</td>
                                <td>{{Lang::get('main.'.\App\Models\UserOrder::$status[$order->status])}}</td>
                                <td>{{$order->pay_method ? \App\Models\UserOrder::$pay_methods[$order->pay_method] : ''}}</td>
                                <td>{{$order->pay_type ? \App\Models\UserOrder::$pay_types[$order->pay_type] : ''}}</td>
                                @if($order->pay_type == \App\Models\UserOrder::DELIVERY)
                                <td>{{$order->delivery_address}}</td>
                                @else
                                <td>{{$order->take_time}}</td>
                                @endif
                                <td>{{$order->created_at}}</td>
                                <td>
                                    <a href="javascript:;" data-id="{{$order->id}}" data-token="{{csrf_token()}}" class="show-order-details-history">{{Lang::get('main.details')}}</a>
                                    <a href="javascript:;" data-id="{{$order->id}}" data-token="{{csrf_token()}}" class="show-order-details-messages">{{Lang::get('main.messages')}}
                                        @if($count_unread_messages)
                                            <span style="color:red">({{$count_unread_messages}})</span>
                                        @endif
                                    </a>
                                    @if($order->status != \App\Models\UserOrder::CLOSED && $order->status != \App\Models\UserOrder::CANCELED)
                                    <a href="/admin/userOrder/{{$order->id}}/edit">Edit</a>
                                    <a href="/admin/userOrder/{{$order->id}}/3" class="approved-order">Approved</a>
                                    <a href="/admin/userOrder/{{$order->id}}/4" class="cancel-order">Close</a>
                                    <a href="/admin/userOrder/{{$order->id}}/5" class="cancel-order">Cancel</a>
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

@endsection