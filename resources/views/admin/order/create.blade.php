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
                                    <select class="form-control" name="to">
                                        <option value="0">Check Organization</option>
                                        @foreach($organizations as $organization)
                                            <option value="{{$organization->id}}">{{$organization->name}}</option>
                                        @endforeach
                                    </select>
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
                            @foreach($warning_drugs as $warning_drug)
                                <tr class="odd gradeX saved">
                                    <td>
                                        {{$warning_drug->drug->trade_name}} <span class="error">({{$warning_drug->count}})</span>
                                        <input type='hidden' class='row-settings' name='settings_{{$i}}' value='{{$warning_drug->drug_settings}}'>
                                        <input type='hidden' class='row-drug-id' name='drug_id_{{$i}}' value='{{$warning_drug->drug_id}}'>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="count" placeholder="Count">
                                        <button class="btn green add-warning-drug">ADD</button>
                                    </td>
                                </tr>
                                <?php $i++ ?>
                            @endforeach
                            @for($i = count($warning_drugs); $i <= 15; $i++)
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
                                    <button type="submit" data-count="0" class="btn green save-all-storage order-save"><i class="fa fa-check"></i>Save</button>
                                    <button type="submit" data-count="0" class="btn yellow save-all-storage order-send"><i class="fa fa-check"></i>Send</button>
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
    <div id="order_message" class="modal fade small" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Message</h4>
                </div>
                {!! Form::open(['id' => 'order_send']) !!}
                <div class="modal-body">
                    <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
                        <div class="row">
                            <div class="col-md-12">
                                <textarea class="order-message form-control" name="message" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn blue">Send</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection