@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>{{Lang::get('admin_main.create_new_admin')}}
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse">
                        </a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {!! Form::open(['url' => 'admin/manage/admins', "class" => "form-horizontal form-bordered admin-form"]) !!}
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
                                <label class="control-label col-md-3">{{Lang::get('admin_main.role')}}</label>
                                <div class="col-md-4">
                                    <select class="form-control" name="role_id">
                                        @foreach($roles as $role)
                                            @if(Input::old('role_id') == $role->id)
                                            <option selected value="{{$role->id}}">{{$role->name}}</option>
                                            @else
                                            <option value="{{$role->id}}">{{$role->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{Lang::get('admin_main.add_new_role_text')}}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">{{Lang::get('admin_main.orgnaization')}}</label>
                                <div class="col-md-4">
                                    <select class="form-control" name="organization_id">
                                        @foreach($organizations as $organization)
                                            @if(Input::old('organization_id') == $organization->id)
                                            <option selected value="{{$organization->id}}">{{$organization->name}}</option>
                                            @else
                                            <option value="{{$organization->id}}">{{$organization->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <span class="help-block">{{Lang::get('admin_main.add_new_organization_text')}}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">{{Lang::get('admin_main.firstname')}}</label>
                                <div class="col-md-4">
                                    {{Form::text('firstname','',['class' => 'form-control'])}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">{{Lang::get('admin_main.lastname')}}</label>
                                <div class="col-md-4">
                                    {{Form::text('lastname','',['class' => 'form-control'])}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">{{Lang::get('admin_main.username')}}</label>
                                <div class="col-md-4">
                                    {{Form::text('email','',['class' => 'form-control'])}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">{{Lang::get('admin_main.password')}}</label>
                                <div class="col-md-4">
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">{{Lang::get('admin_main.confirm_password')}}</label>
                                <div class="col-md-4">
                                    <input type="password" class="form-control" name="password_confirmation">
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
