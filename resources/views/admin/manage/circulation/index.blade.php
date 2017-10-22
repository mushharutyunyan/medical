@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box grey-cascade">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-user"></i>{{Lang::get('admin_main.circulation')}}
                    </div>
                </div>
                <div class="portlet-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <ul class="nav nav-tabs">
                        <li class="{{isset($data['circulation_order_whole_sale']) && isset($data['circulation_order_pharmacy']) ? '' : 'active'}}"><a data-toggle="tab" href="#user_order">{{Lang::get('admin_main.user_order')}}</a></li>
                        <li class="{{isset($data['circulation_order_whole_sale']) && isset($data['circulation_order_pharmacy']) ? 'active' : ''}}"><a data-toggle="tab" href="#order">{{Lang::get('admin_main.order')}}</a></li>
                    </ul>

                    <div class="tab-content">
                        <div id="user_order" class="tab-pane fade  {{(isset($data['circulation_order_whole_sale']) && isset($data['circulation_order_pharmacy'])) ? '' : 'in active'}}">
                            @if(Auth::guard('admin')->user()['role_id'] == 1)
                            <form method="POST">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="form-group col-md-6">
                                    <label>{{Lang::get('admin_main.by_user')}}:</label>
                                    <select name="circulation_users" id="circulation_users" class="form-control">
                                        <option></option>
                                        @foreach($users as $user)
                                            @if($user->user)
                                                @if(isset($data['circulation_users']) && $data['circulation_users'] == $user->user_id)
                                                <option selected value="{{$user->user->id}}">{{$user->user->name}}</option>
                                                @else
                                                <option value="{{$user->user->id}}">{{$user->user->name}}</option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>{{Lang::get('admin_main.by_organization')}}:</label>
                                    <select name="user_order_organizations" id="user_order_organizations" class="form-control">
                                        <option></option>
                                        @foreach($user_order_organizations as $user_order_organization)
                                            @if($user_order_organization->organization)
                                                @if(isset($data['user_order_organizations']) && $data['user_order_organizations'] == $user_order_organization->organization_id)
                                                    <option selected value="{{$user_order_organization->organization->id}}">{{$user_order_organization->organization->name}}</option>
                                                @else
                                                    <option value="{{$user_order_organization->organization->id}}">{{$user_order_organization->organization->name}}</option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                            @endif
                            <table class="table table-striped table-bordered table-hover user_order_datatable">
                                <thead>
                                    <tr>
                                        <th>
                                            {{Lang::get('admin_main.user')}}
                                        </th>
                                        <th>
                                            {{Lang::get('admin_main.organization')}}
                                        </th>
                                        <th>
                                            {{Lang::get('admin_main.order')}}
                                        </th>
                                        <th>
                                            {{Lang::get('admin_main.created_at')}}
                                        </th>
                                        <th>
                                            {{Lang::get('admin_main.sum')}}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $user_order_all_sum = 0;
                                    ?>
                                    @foreach($user_orders as $user_order)
                                        <?php
                                            $user_order_sum = 0;
                                        ?>
                                        @foreach($user_order->order_details as $order_detail)
                                            <?php
                                                $user_order_sum += $order_detail->price * $order_detail->count;
                                                $user_order_all_sum += $user_order_sum;
                                            ?>
                                        @endforeach
                                        <tr>
                                            <td>
                                                @if($user_order->user_id)
                                                    {{$user_order->user->name}}
                                                    {{$user_order->user->phone}}
                                                @else
                                                    {{$user_order->unknown_user_email}}
                                                    {{$user_order->unknown_user_phone}}
                                                @endif
                                            </td>
                                            <td>
                                                {{$user_order->organization->name}}
                                            </td>
                                            <td>
                                                {{$user_order->order}}
                                            </td>
                                            <td>
                                                {{$user_order->created_at}}
                                            </td>
                                            <td>
                                                {{$user_order_sum}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="form-group">
                                <label>{{Lang::get('admin_main.by_organization_sum')}}:</label>
                                <input type="text" class="form-control" disabled="disabled" value="{{$user_order_all_sum}}">
                            </div>
                        </div>
                        <div id="order" class="tab-pane fade {{(isset($data['circulation_order_whole_sale']) && isset($data['circulation_order_pharmacy'])) ? 'in active' : ''}}">
                            @if(Auth::guard('admin')->user()['role_id'] == 1)
                                <form method="POST">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <div class="form-group col-md-6">
                                        <label>{{Lang::get('admin_main.whole_sale')}}:</label>
                                        <select name="circulation_order_whole_sale" id="circulation_order_whole_sale" class="form-control">
                                            <option></option>
                                            @foreach($organizations as $organization)
                                                @if($organization->status == \App\Models\Organization::WHOLESALE)
                                                    @if(isset($data['circulation_order_whole_sale']) && $data['circulation_order_whole_sale'] == $organization->id)
                                                        <option selected value="{{$organization->id}}">{{$organization->name}}</option>
                                                    @else
                                                        <option value="{{$organization->id}}">{{$organization->name}}</option>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>{{Lang::get('admin_main.pharmacy_other')}}:</label>
                                        <select name="circulation_order_pharmacy" id="circulation_order_pharmacy" class="form-control">
                                            <option></option>
                                            @foreach($organizations as $organization)
                                                @if($organization->status != \App\Models\Organization::WHOLESALE)
                                                    @if(isset($data['circulation_order_pharmacy']) && $data['circulation_order_pharmacy'] == $organization->id)
                                                        <option selected value="{{$organization->id}}">{{$organization->name}}</option>
                                                    @else
                                                        <option value="{{$organization->id}}">{{$organization->name}}</option>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </form>
                            @endif
                            <table class="table table-striped table-bordered table-hover order_datatable">
                                <thead>
                                    <tr>
                                        <th>
                                            {{Lang::get('admin_main.to')}}
                                        </th>
                                        <th>
                                            {{Lang::get('admin_main.from')}}
                                        </th>
                                        <th>
                                            {{Lang::get('admin_main.delivery_status')}}
                                        </th>
                                        <th>
                                            {{Lang::get('admin_main.sum_with_discount')}}
                                        </th>
                                        <th>
                                            {{Lang::get('admin_main.create_at_finish_date')}}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $all_order_sum = 0;
                                ?>
                                @foreach($orders as $order)
                                    <?php
                                        $order_sum = 0;
                                        $order_discounted_sum = 0;
                                    ?>
                                    @if($order->orderInfo)
                                        @foreach($order->orderInfo as $orderInfo)
                                            <?php
                                            if(!$orderInfo->storage){
                                                continue;
                                            }
                                            $order_sum += $orderInfo->storage->price->price * $orderInfo->count;
                                            ?>
                                        @endforeach
                                        <?php
                                            $order_discounted_sum = $order_sum - $order_sum * $order->discount/100;
                                            $all_order_sum += $order_discounted_sum;
                                        ?>
                                    @endif
                                    <tr>
                                        <td>
                                            {{$order->organizationTo->name}}
                                        </td>
                                        <td>
                                            {{$order->organizationFrom->name}}
                                        </td>
                                        <td>

                                            @if($order->delivery_status)
                                                {{$order->delivery_status->name}}
                                            @endif
                                        </td>
                                        <td class="circulation-order-sum-field" data-discounted-price="{{$order_discounted_sum}}">
                                            {{$order_sum}}, With Discount: {{$order_discounted_sum}}
                                        </td>
                                        <td>
                                            {{$order->created_at}} ({{$order->updated_at}})
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="form-group">
                                <label>{{Lang::get('admin_main.order_sum')}}:</label>
                                <input type="text" class="form-control" disabled="disabled" value="{{$all_order_sum}}">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection