@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box grey-cascade">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-user"></i>Order ({{Auth::guard('admin')->user()->organization->name}})
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="form-body">
                            <div class="form-group">
                                <div class="col-md-4">
                                    <h2>{{$order->organizationTo->name}}</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-body">
                        <table class="table table-striped table-bordered table-hover order-actions-table">
                            <thead>
                            <tr>
                                <th>Drug</th>
                                <th>Count</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 0 ?>
                            @foreach($drugs as $drug)
                                <tr class="odd gradeX process">
                                    <td>
                                        <button class='view-edit-drug order btn btn-warning' data-id='{{$order->id}}' data-drug-id="{{$drug->drug_id}}">Watch</button>
                                        <button class='remove-storage-row btn btn-warning order' data-id='{{$i}}'>Clear</button>
                                        {{$drug->drug->trade_name}}
                                        <input type='hidden' class='row-storage-id' name='storage_id_{{$i}}' value='{{$drug->storage_id}}'>
                                        <input type='hidden' class='row-count-in-storage' name='count_in_storage_{{$i}}' value='{{$drug->count}}'>

                                    @foreach($drug_settings as $key => $drug_setting)
                                            @foreach($drug->drug->$key as $key_setting => $setting)
                                                @if(preg_match('/price/',$key))
                                                <p>{{$drug->drug->setting_names[$key]}}: {{$setting->price}}</p>
                                                @elseif(preg_match('/count/',$key))
                                                <p>{{$drug->drug->setting_names[$key]}}: {{$setting->count}}</p>
                                                @else
                                                <p>{{$drug->drug->setting_names[$key]}}: {{$setting->name}}</p>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="{{$drug->count}}" name="count" placeholder="Count">
                                    </td>
                                </tr>
                                <?php $i++ ?>
                            @endforeach
                            @for($i = count($drugs); $i <= 15; $i++)
                                <tr class="odd gradeX">
                                    <td><button type="button" data-id="{{$i}}" class="btn btn-success search-drug-button order">Search</button></td>
                                    <td><input type="text" class="form-control" name="count" placeholder="Count"></td>
                                </tr>
                            @endfor
                            </tbody>
                        </table>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="pull-left">
                                    <select class="count-storage-row form-control">
                                        <option value="1">1</option>
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="15">15</option>
                                        <option value="25">25</option>
                                    </select>
                                    <button type="button" class="btn blue add-storage-row"><i class="fa fa-plus"></i>Add</button>
                                </div>
                                <div class="pull-right">
                                    {!! Form::open(['class' => 'storage-save-all']) !!}
                                    @if(!$order->status)
                                    <button type="submit" data-count="0" data-id="{{$order->id}}" class="btn green save-all-storage order-save edit"><i class="fa fa-check"></i>Save</button>
                                    <button type="submit" data-count="0" data-id="{{$order->id}}" class="btn yellow save-all-storage order-send edit"><i class="fa fa-check"></i>Send</button>
                                    @else
                                        @if(Auth::guard('admin')->user()['organization_id'] == $order->to)
                                        <button type="submit" data-count="0" data-id="{{$order->id}}" class="btn yellow save-all-storage order-send edit answer"><i class="fa fa-check"></i>Re-Send</button>
                                        @else
                                        <button type="submit" data-count="0" data-id="{{$order->id}}" class="btn yellow save-all-storage order-send edit"><i class="fa fa-check"></i>Re-Send</button>
                                        @endif
                                    @endif
                                    <a href="{{url()->previous()}}" type="button" class="btn default">Cancel</a>
                                    {!! Form::close() !!}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>

@endsection