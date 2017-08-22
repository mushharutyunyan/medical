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
                            <th>Price</th>
                            <th>Count</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @for($i = 0; $i <= 15; $i++)
                            <tr class="odd gradeX">
                                <td><button type="button" data-id="{{$i}}" class="btn btn-success search-drug-button">Search</button></td>
                                <td><input type="text" class="form-control" name="price" placeholder="Price"></td>
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
                                    </select>
                                    <button type="button" class="btn blue add-storage-row"><i class="fa fa-plus"></i>Add</button>
                                </div>
                                <div class="pull-right">
                                    {!! Form::open(['class' => 'storage-save-all']) !!}
                                        <button type="submit" data-count="0" class="btn green save-all-storage"><i class="fa fa-check"></i>Save</button>
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

@endsection