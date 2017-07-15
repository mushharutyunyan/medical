@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box grey-cascade">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-user"></i>Add ({{Auth::guard('admin')->user()->organization->name}})
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered table-hover storage-actions-table">
                        <thead>
                        <tr>
                            <th>Drug</th>
                            <th>Count</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @for($i = 0; $i <= 15; $i++)
                            <tr class="odd gradeX">
                                <td><button type="button" data-id="{{$i}}" class="btn btn-success search-drug-button">Search</button></td>
                                <td><input type="text" class="form-control" name="count" placeholder="Count"></td>
                                <td>
                                    <button class="btn green save-storage-row">Save</button>
                                </td>
                            </tr>
                        @endfor
                        </tbody>
                    </table>
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
                                        <option value="25">25</option>
                                    </select>
                                    <button type="button" class="btn blue add-storage-row"><i class="fa fa-plus"></i>Add</button>
                                </div>
                                <div class="pull-right">
                                    {!! Form::open(['class' => 'storage-save-all']) !!}
                                        <button type="submit" data-count="0" class="btn green save-all-storage"><i class="fa fa-check"></i>Save All</button>
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
    <div id="search_drug" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                    <h4 class="modal-title">Search Drug</h4>
                </div>
                <div class="modal-body">

                    <div class="scroller" style="height:300px" data-always-visible="1" data-rail-visible1="1">
                        <div class="row">
                            <div class="col-md-6">
                                <p>
                                    <input type="text" class="form-control search-drug" placeholder="Type and click other place in popup">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <span class="error"></span>
                                </p>
                            </div>
                        </div>
                        <div class="row drug-content">

                        </div>

                        <div class="row drug-settings" style="display: none">
                            <div class="col-md-12">
                                <table class="table table-striped table-bordered table-hover drug-settings-table" style="margin-top: 10px;">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Info</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <img width="20%" style="display:none" class="drug-loader" src="/assets/admin/img/loader-drugs.gif">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {!! Form::open(['class' => 'storage-save']) !!}
                    <button type="button" data-dismiss="modal" class="btn default">Close</button>
                    <button type="submit" class="btn green check-drug">Save changes</button>
                    {!! Form::close([]) !!}
                </div>
            </div>
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