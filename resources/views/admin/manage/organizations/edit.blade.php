@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>{{Lang::get('admin_main.edit_organization')}}
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse">
                        </a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {{ Form::model($currentOrganization, ['url' => '/admin/manage/organizations/'.$currentOrganization->id, 'method' => 'PUT', 'class' => 'form-horizontal form-bordered role-form']) }}
                    <div class="form-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul class="list-group">
                                    @foreach ($errors->all() as $error)
                                        <li class="list-group-item">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-group">
                            <label class="control-label col-md-3">{{Lang::get('admin_main.name')}}</label>
                            <div class="col-md-4">
                                {{Form::text('name',$currentOrganization->name,['class' => 'form-control'])}}
                            </div>
                        </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">{{Lang::get('admin_main.director')}}</label>
                                <div class="col-md-4">
                                    {{Form::text('director',$currentOrganization->director,['class' => 'form-control'])}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">{{Lang::get('admin_main.status')}}</label>
                                <div class="col-md-4">
                                    <select class="form-control" name="status">
                                        @foreach($status as $key => $value)
                                            @if(Input::old('status') == $key)
                                                <option selected value="{{$key}}">{{$value}}</option>
                                            @else
                                                @if($currentOrganization->status == $key)
                                                    <option selected value="{{$key}}">{{$value}}</option>
                                                @else
                                                    <option value="{{$key}}">{{$value}}</option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">{{Lang::get('admin_main.email')}}</label>
                                <div class="col-md-4">
                                    {{Form::text('email',$currentOrganization->email,['class' => 'form-control'])}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">{{Lang::get('admin_main.city')}}</label>
                                <div class="col-md-4">
                                    {{Form::text('city',$currentOrganization->city,['class' => 'form-control'])}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">{{Lang::get('admin_main.street')}}</label>
                                <div class="col-md-4">
                                    {{Form::text('street',$currentOrganization->street,['class' => 'form-control'])}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">{{Lang::get('admin_main.apartment')}}</label>
                                <div class="col-md-4">
                                    {{Form::text('apartment',$currentOrganization->apartment,['class' => 'form-control'])}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">{{Lang::get('admin_main.phone')}}</label>
                                <div class="col-md-4">
                                    {{Form::text('phone',$currentOrganization->phone,['class' => 'form-control'])}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">{{Lang::get('admin_main.identification_number')}}</label>
                                <div class="col-md-4">
                                    {{Form::text('identification_number',$currentOrganization->identification_number,['class' => 'form-control'])}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">{{Lang::get('admin_main.bank_account_number')}}</label>
                                <div class="col-md-4">
                                    {{Form::text('bank_account_number',$currentOrganization->bank_account_number,['class' => 'form-control'])}}
                                </div>
                            </div>
                            <input type="hidden"  name="latitude" value="{{$position->latitude}}">
                            <input type="hidden" name="longitude" value="{{$position->longitude}}">
                            <input id="pac-input" class="controls form-control" type="text" placeholder="{{Lang::get('admin_main.search')}}">
                            <div id="map" data-type="edit"></div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn green"><i class="fa fa-check"></i> {{Lang::get('admin_main.submit')}}</button>
                                <a href="{{url()->previous()}}" type="button" class="btn default">{{Lang::get('admin_main.cancel')}}</a>
                            </div>
                        </div>
                    </div>
                {!! Form::close() !!}
                <!-- END FORM-->
                </div>
            </div>
            <!-- END PORTLET-->
        </div>
    </div>


@endsection
