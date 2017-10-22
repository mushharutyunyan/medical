@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>{{Lang::get('admin_main.create_role')}}
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse">
                        </a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {!! Form::open(['url' => 'admin/manage/roles', "class" => "form-horizontal form-bordered role-form"]) !!}
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
