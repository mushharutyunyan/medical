@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box grey-cascade">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-user"></i>{{Lang::get('admin_main.order')}} ({{Auth::guard('admin')->user()->organization->name}})
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="form-body">
                            <div class="form-group">
                                <div class="col-md-4">
                                    {!! Form::open(['url' => 'admin/order/changeOrganization', "class" => "change_organization_form"]) !!}
                                    <select class="form-control" name="to" id="order_organization_list" >
                                        <option value="0">{{Lang::get('admin_main.check_organization')}}</option>
                                        @foreach($organizations as $organization)
                                            @if(Input::old('to') == $organization->id)
                                            <option selected value="{{$organization->id}}">{{$organization->name}}</option>
                                            @else
                                            <option value="{{$organization->id}}">{{$organization->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-body">
                        <table class="table table-striped table-bordered table-hover order-actions-table">
                            <thead>
                            <tr>
                                <th>{{Lang::get('admin_main.drug')}}</th>
                                <th>{{Lang::get('admin_main.count')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @for($i = 0; $i <= 15; $i++)
                                <tr class="odd gradeX">
                                    <td><button type="button" data-id="{{$i}}" class="btn btn-success search-drug-button order">{{Lang::get('admin_main.search')}}</button></td>
                                    <td><input type="text" class="form-control" name="count" placeholder="{{Lang::get('admin_main.count')}}"></td>
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
                                    <button type="button" class="btn blue add-storage-row"><i class="fa fa-plus"></i>{{Lang::get('admin_main.add')}}</button>
                                </div>
                                <div class="pull-right">
                                    {!! Form::open(['class' => 'storage-save-all']) !!}
                                    <button type="submit" data-count="0" class="btn green save-all-storage order-save"><i class="fa fa-check"></i>{{Lang::get('admin_main.save')}}</button>
                                    <button type="submit" data-count="0" class="btn yellow save-all-storage order-send"><i class="fa fa-check"></i>{{Lang::get('admin_main.send')}}</button>
                                    <a href="{{url()->previous()}}" type="button" class="btn default">{{Lang::get('admin_main.cancel')}}</a>
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