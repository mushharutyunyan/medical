@extends('layouts.main')
@section('title', config('app.name')." | ".Lang::get('main.orderDetails'))
@section('content')

    <div class="shell">
        <div>
            <ol class="breadcrumb">
                <li><a href="/" class="icon icon-sm fa-home text-primary"></a></li>
                <li class="active">Orders
                </li>
            </ol>
        </div>
    </div>
    <div class="shell section-bottom-60 offset-top-4">
        <div class="table-responsive section-bottom-60">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>{{Lang::get('main.id')}}</th>
                    <th>{{Lang::get('main.organization')}}</th>
                    <th >{{Lang::get('main.status')}}</th>
                    <th >{{Lang::get('main.pay_type')}}</th>
                    <th >{{Lang::get('main.delivery_address_take_time')}}</th>
                    <th >{{Lang::get('main.delivery_address_time')}}</th>
                    <th>{{Lang::get('main.createdAt')}}</th>
                    <th>{{Lang::get('main.show')}}</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <?php
                        $count_unread_messages = \App\Models\UserOrderMessage::where('user_order_id',$order->id)->where('read',0)->where('from','pharmacy')->count();
                        ?>
                    <?php
                    $style = 'text-align: left';
                    ?>
                    @if($order->status == \App\Models\UserOrder::DELIVERED)
                        <?php $style = 'text-align:left;background-color:#7fcbc9'; ?>
                    @endif
                        <tr style="{{$style}}">
                            <td>{{$order->order}}</td>
                            <td>{{$order->organization->name}}</td>
                            <td>{{Lang::get('main.'.\App\Models\UserOrder::$status[$order->status])}}</td>
                            <td>{{$order->pay_type ? \App\Models\UserOrder::$pay_types[$order->pay_type] : ''}}</td>
                            @if($order->pay_type == \App\Models\UserOrder::DELIVERY)
                                <td class="pay_type">{{$order->delivery_address}}</td>
                            @else
                                <td class="pay_type">{{$order->take_time}}</td>
                            @endif
                            <td class="pay_type">{{date("Y-m-d H:i:s",strtotime($order->delivery_time . ' +4 hour'))}}</td>

                            <td>{{date("Y-m-d H:i:s",strtotime($order->created_at . ' +4 hour'))}}</td>
                            <td>
                                <form id="canceled_by_user">
                                @if($order->status == \App\Models\UserOrder::APPROVED && !$order->pay_method)
                                    <button class="btn btn-success pay-order" type="button" data-order="{{$order->order}}">{{Lang::get('main.pay')}}</button>
                                @endif
                                <a href="javascript:;" data-id="{{$order->id}}" data-token="{{csrf_token()}}" class="show-order-details-history btn btn-info">{{Lang::get('main.details')}}</a>
                                <a href="javascript:;" data-id="{{$order->id}}" data-token="{{csrf_token()}}" class="show-order-details-messages btn btn-info">{{Lang::get('main.messages')}}
                                    @if($count_unread_messages)
                                    <span style="color:red">({{$count_unread_messages}})</span>
                                    @endif
                                </a>
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="hidden" name="id" value="{{$order->id}}">
                                @if($order->status != \App\Models\UserOrder::CANCELED && $order->status != \App\Models\UserOrder::CANCELEDBYUSER)
                                    <button class="btn btn-blue canceled_closed_by_user canceled">{{Lang::get('main.cancel')}}</button>
                                    @if($order->status >= \App\Models\UserOrder::APPROVEDBYPHARMACY)
                                        <button class="btn btn-blue canceled_closed_by_user closed">{{Lang::get('main.close')}}</button>
                                    @endif
                                @endif
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
                        <th>{{Lang::get('main.name')}}</th>
                        <th>{{Lang::get('main.count')}}</th>
                        <th>{{Lang::get('main.price')}}</th>
                        <th>{{Lang::get('main.sum')}}</th>
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