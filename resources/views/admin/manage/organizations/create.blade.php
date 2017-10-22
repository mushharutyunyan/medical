@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>{{Lang::get('admin_main.create_organization')}}
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse">
                        </a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {!! Form::open(['url' => 'admin/manage/organizations', "class" => "form-horizontal form-bordered role-form", "enctype" => "multipart/form-data"]) !!}
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
                                {{Form::text('name','',['class' => 'form-control'])}}
                                @if(Input::old('redirect_url'))
                                <input type="hidden" value="{{Input::old('redirect_url')}}" name="redirect_url">
                                @else
                                <input type="hidden" value="{{url()->previous()}}" name="redirect_url">
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">{{Lang::get('admin_main.director')}}</label>
                            <div class="col-md-4">
                                {{Form::text('director','',['class' => 'form-control'])}}
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
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">{{Lang::get('admin_main.email')}}</label>
                            <div class="col-md-4">
                                {{Form::text('email','',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">{{Lang::get('admin_main.city')}}</label>
                            <div class="col-md-4">
                                {{Form::text('city','',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">{{Lang::get('admin_main.street')}}</label>
                            <div class="col-md-4">
                                {{Form::text('street','',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">{{Lang::get('admin_main.apartment')}}</label>
                            <div class="col-md-4">
                                {{Form::text('apartment','',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">{{Lang::get('admin_main.phone')}}</label>
                            <div class="col-md-4">
                                {{Form::text('phone','',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">{{Lang::get('admin_main.identification_number')}}</label>
                            <div class="col-md-4">
                                {{Form::text('identification_number','',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">{{Lang::get('admin_main.bank_account_number')}}</label>
                            <div class="col-md-4">
                                {{Form::text('bank_account_number','',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">{{Lang::get('admin_main.picture')}}</label>
                            <div class="col-md-4">
                                {{Form::file('picture','',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <input type="hidden"  name="latitude" value="{{$position->latitude}}">
                        <input type="hidden" name="longitude" value="{{$position->longitude}}">
                        <input id="pac-input" class="controls form-control" type="text" placeholder="{{Lang::get('admin_main.search')}}">
                        <div id="map" data-type="create"></div>
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
