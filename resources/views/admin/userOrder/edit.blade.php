@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box grey-cascade">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-user"></i>{{Lang::get('admin_main.user_order_details')}}
                    </div>
                </div>
                <div class="portlet-body">
                    {!! Form::open(['class' => 'changeOrderDetails']) !!}
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th></th>
                            <th>{{Lang::get('admin_main.drug')}}</th>
                            <th>{{Lang::get('admin_main.count')}}</th>
                            <th>{{Lang::get('admin_main.price')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($details as $detail)
                            <tr style="text-align: left">
                                <input type="hidden" name="id" value="{{$detail->id}}">
                                <td><a href="javascript:;" class="delete-order-detail" data-id="{{$detail->id}}"><i class="fa fa-remove"></i></a></td>
                                <td>{{$detail->storage->drug->trade_name}}</td>
                                <td><input class="form-control" type="text" name="count" value="{{$detail->count}}"></td>
                                <td><input class="form-control" type="text" name="price" value="{{$detail->price}}"></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <button class="btn blue">{{Lang::get('admin_main.save')}}</button>
                    {!! Form::close() !!}
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
    <div id="sendUserOrderMessageModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{Lang::get('main.orderDetails')}}</h4>
                </div>
                {!! Form::open(['url' => 'admin/userOrder/details/save', 'class' => 'saveOrderDetails']) !!}
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id" value="{{$user_order->id}}">
                        <select name="status" class="form-control">
                            @if($user_order->status == \App\Models\UserOrder::APPROVED)
                                <option value="{{\App\Models\UserOrder::APPROVED}}">Approved</option>
                            @else
                                <option value="{{\App\Models\UserOrder::RESEND}}">Re Send</option>
                                <option value="{{\App\Models\UserOrder::APPROVED}}">Approved</option>
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="details">
                        <textarea class="form-control" rows="5" name="message" id="message"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn blue">{{Lang::get('admin_main.update')}}</button>
                </div>
                {!! Form::close() !!}
            </div>

        </div>

@endsection