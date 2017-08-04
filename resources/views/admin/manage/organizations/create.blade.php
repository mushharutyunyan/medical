@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>Create new organization
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
                            <label class="control-label col-md-3">Name</label>
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
                            <label class="control-label col-md-3">Director</label>
                            <div class="col-md-4">
                                {{Form::text('director','',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Status</label>
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
                            <label class="control-label col-md-3">Email</label>
                            <div class="col-md-4">
                                {{Form::text('email','',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">City</label>
                            <div class="col-md-4">
                                {{Form::text('city','',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Street</label>
                            <div class="col-md-4">
                                {{Form::text('street','',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Apartment</label>
                            <div class="col-md-4">
                                {{Form::text('apartment','',['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Picture</label>
                            <div class="col-md-4">
                                {{Form::file('picture','',['class' => 'form-control'])}}
                            </div>
                        </div>
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-9">
                                <button type="submit" class="btn green"><i class="fa fa-check"></i> Submit</button>
                                <a href="{{url()->previous()}}" type="button" class="btn default">Cancel</a>
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
