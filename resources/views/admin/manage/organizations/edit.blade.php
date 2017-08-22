@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>Edit new organization
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
                            <label class="control-label col-md-3">Name</label>
                            <div class="col-md-4">
                                {{Form::text('name',$currentOrganization->name,['class' => 'form-control'])}}
                            </div>
                        </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Director</label>
                                <div class="col-md-4">
                                    {{Form::text('director',$currentOrganization->director,['class' => 'form-control'])}}
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
                                <label class="control-label col-md-3">Email</label>
                                <div class="col-md-4">
                                    {{Form::text('email',$currentOrganization->email,['class' => 'form-control'])}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">City</label>
                                <div class="col-md-4">
                                    {{Form::text('city',$currentOrganization->city,['class' => 'form-control'])}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Street</label>
                                <div class="col-md-4">
                                    {{Form::text('street',$currentOrganization->street,['class' => 'form-control'])}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Apartment</label>
                                <div class="col-md-4">
                                    {{Form::text('apartment',$currentOrganization->apartment,['class' => 'form-control'])}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Phone</label>
                                <div class="col-md-4">
                                    {{Form::text('phone',$currentOrganization->phone,['class' => 'form-control'])}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Identification number</label>
                                <div class="col-md-4">
                                    {{Form::text('identification_number',$currentOrganization->identification_number,['class' => 'form-control'])}}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-3">Bank account number</label>
                                <div class="col-md-4">
                                    {{Form::text('bank_account_number',$currentOrganization->bank_account_number,['class' => 'form-control'])}}
                                </div>
                            </div>
                            <input type="hidden"  name="latitude" value="{{$position->latitude}}">
                            <input type="hidden" name="longitude" value="{{$position->longitude}}">
                            <input id="pac-input" class="controls form-control" type="text" placeholder="Search Box">
                            <div id="map" data-type="edit"></div>
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
