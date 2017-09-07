@extends('layouts.main')
@section('title', config('app.name')." | ".Lang::get('main.orderDetails'))
@section('content')

    <div class="shell">
        <div>
            <ol class="breadcrumb">
                <li><a href="/" class="icon icon-sm fa-home text-primary"></a></li>
                <li class="active">Search Order
                </li>
            </ol>
        </div>
    </div>
    <div class="shell section-bottom-60 offset-top-4">
        <div class="row">
            @if (count($errors) > 0)
                <div class="col-sm-4">
                        <div class="alert alert-danger">
                            <ul class="list-group">
                                @foreach ($errors->all() as $error)
                                    <li class="list-group-item">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                </div>
            @endif
        </div>
        <div class="row section-bottom-60">
            <form action="/order/details" method="POST">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="col-sm-4">
                    <div class="form-group">

                        <input type="text" name="searchOrder" class="form-control" placeholder="{{Lang::get('main.enterOrderId')}}">
                    </div>
                </div>
                <div class="col-sm-4">
                    <button class="btn btn-default pull-left">{{Lang::get('main.search')}}</button>
                </div>
            </form>
        </div>
        @if(isset($details))
        <div class="table-responsive section-bottom-60">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>{{Lang::get('main.id')}}</th>
                        <th>{{Lang::get('main.organization')}}</th>
                        <th >{{Lang::get('main.status')}}</th>
                        <th >{{Lang::get('main.pay_type')}}</th>
                        <th >{{Lang::get('main.delivery_address_take_time')}}</th>
                        <th>{{Lang::get('main.createdAt')}}</th>
                        <th>{{Lang::get('main.details')}}</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $count_unread_messages = \App\Models\UserOrderMessage::where('user_order_id',$details->id)->where('read',0)->where('from','pharmacy')->count();
                    $style = 'text-align: left';
                ?>
                @if($details->status == \App\Models\UserOrder::DELIVERED)
                    <?php $style = 'text-align:left;background-color:#7fcbc9'; ?>
                @endif

                    <tr style="{{$style}}">
                        <td>{{$details->order}}</td>
                        <td>{{$details->order_details[0]->storage->organization->name}}</td>
                        <td>{{Lang::get('main.'.\App\Models\UserOrder::$status[$details->status])}}</td>
                        <td>{{$details->pay_type ? \App\Models\UserOrder::$pay_types[$details->pay_type] : ''}}</td>
                        @if($details->pay_type == \App\Models\UserOrder::DELIVERY)
                            <td class="pay_type">{{$details->delivery_address}}</td>
                        @else
                            <td class="pay_type">{{$details->take_time}}</td>
                        @endif
                        <td>{{$details->created_at}}</td>
                        <td>
                            <form id="canceled_by_user">
                            @if($details->status == \App\Models\UserOrder::APPROVED && !$details->pay_method)
                                <button class="btn btn-success pay-order" type="button" data-order="{{$details->order}}">{{Lang::get('main.pay')}}</button>
                            @endif
                            @if($count_unread_messages)
                                <span style="color:red">Unread Messages ({{$count_unread_messages}}) </span>
                            @endif
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <input type="hidden" name="id" value="{{$details->id}}">
                                <button type="button" class="show-order-details btn btn-blue">{{Lang::get('main.show')}}</button>
                                @if($details->status != \App\Models\UserOrder::CANCELED && $details->status != \App\Models\UserOrder::CANCELEDBYUSER)
                                <button class="btn btn-blue canceled_closed_by_user canceled">{{Lang::get('main.cancel')}}</button>
                                @endif
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group chat">
                    @foreach($messages as $message)
                    <div class="message">
                        @if($message->from == 'user')
                        <span>{{Lang::get('main.you')}}: {{date("Y-m-d",strtotime($message->created_at . "+ 4 hour"))}}</span>
                        @else
                        <span>{{Lang::get('main.pharmacy')}}: ({{date("Y-m-d",strtotime($message->created_at . "+ 4 hour"))}})</span>
                        @endif
                        <p>{{$message->message}}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row">
            <form action="/order/createMessage" method="POST" class="add-order-message">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <div class="col-sm-11">
                    <input type="text" name="message" id="message" placeholder="{{Lang::get('main.enterTextMessage')}}" class="form-control">
                    <input type="hidden" value="{{$details->order}}" name="order">
                    <input type="hidden" value="anonymus" name="user">
                    <input type="hidden" value="{{$details->id}}" name="id">
                </div>
                <div class="col-sm-1">
                    <button class="btn btn-default pull-right">{{Lang::get('main.send')}}</button>
                </div>
            </form>
        </div>
        @endif
    </div>
    @if(isset($details))
    <!-- Modal -->
    <div id="showOrderDetailsModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{Lang::get('main.orderDetails')}}</h4>
                </div>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>{{Lang::get('main.name')}}</th>
                        <th>{{Lang::get('main.count')}}</th>
                        <th>{{Lang::get('main.price')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($details->order_details as $drugs)
                        <tr style="text-align: left">
                            @if(App::getLocale('am'))
                            <td>{{$drugs->storage->drug->trade_name}}</td>
                            @elseif(App::getLocale('ru'))
                            <td>{{$drugs->storage->drug->trade_name_ru}}</td>
                            @elseif(App::getLocale('en'))
                            <td>{{$drugs->storage->drug->trade_name_en}}</td>
                            @endif
                            <td>{{$drugs->count}}</td>
                            <td>{{$drugs->price*$drugs->count}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    @endif
@endsection