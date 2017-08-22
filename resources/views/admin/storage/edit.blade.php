@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-gift"></i>Edit Storage ({{$currentDrug->trade_name}})
                    </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse">
                        </a>
                    </div>
                </div>
                <div class="portlet-body form">
                    <!-- BEGIN FORM-->
                    {{ Form::model($storage, ['url' => '/admin/storage/'.$storage->id, 'method' => 'PUT', 'class' => 'form-horizontal form-bordered storage-edit-form']) }}
                    <div class="form-body">
                        {{Form::hidden('drug_id',$currentDrug->id)}}
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
                            <label class="control-label col-md-3">Generic Name</label>
                            <div class="col-md-4">
                                {{Form::text('',$currentDrug->generic_name,['class' => 'form-control','disabled' => 'disabled'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Dosage Form</label>
                            <div class="col-md-4">
                                {{Form::text('',$currentDrug->dosage_form,['class' => 'form-control','disabled' => 'disabled'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Dosage Strength</label>
                            <div class="col-md-4">
                                {{Form::text('',$currentDrug->dosage_strength,['class' => 'form-control','disabled' => 'disabled'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Code</label>
                            <div class="col-md-4">
                                {{Form::text('',$currentDrug->code,['class' => 'form-control','disabled' => 'disabled'])}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3">Count</label>
                            <div class="col-md-4">
                                {{Form::text('storage_count',$storage->count,['class' => 'form-control'])}}
                            </div>
                        </div>
                        @foreach($settings_info as $key => $settings)
                            <div class="form-group">
                                <label class="control-label col-md-3">{{$settings}}</label>
                                <div class="col-md-4">
                                    @if(preg_match('/price/',$key))
                                        <input class="form-control" value="{{$storage->price->price}}" name="price">
                                    @else
                                        <select class="form-control" name="{{$key}}">
                                            <option></option>
                                            @foreach($currentDrug->$key as $setVal)
                                                <?php $attr = ''; ?>
                                                @if($key == 'count')
                                                    <?php $name = $setVal->count ?>
                                                @elseif(preg_match('/date/',$key))
                                                    <?php $name = $setVal->date ?>
                                                @else
                                                    @if($key == 'picture')
                                                        <?php $attr = 'data-src='.$setVal->name; ?>
                                                    @elseif($key == 'character')
                                                        <?php $attr = 'data-text='.$setVal->name; ?>
                                                    @endif
                                                    <?php $name = $setVal->name ?>
                                                @endif
                                                @if(isset($currentSettings->$key))
                                                    @if($currentSettings->$key == $setVal->id)
                                                    <option selected {{$attr}} value="{{$setVal->id}}">{{$name}}</option>
                                                    @else
                                                    <option {{$attr}} value="{{$setVal->id}}">{{$name}}</option>
                                                    @endif
                                                @else
                                                    <option {{$attr}} value="{{$setVal->id}}">{{$name}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @if($key == 'picture')
                                            <button type="button" class="open-picture btn blue">Open</button>
                                        @elseif($key == 'character')
                                            <button type="button" class="open-character btn blue">Open</button>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-9 col-md-3">
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
    <!-- /.modal -->
    <div class="modal fade bs-modal-sm" id="watch" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body-watch">

                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
