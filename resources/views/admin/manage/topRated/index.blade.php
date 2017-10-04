@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box grey-cascade">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-user"></i>Managed Top Rated Drugs
                    </div>
                </div>
                <div class="portlet-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <a id="sample_editable_1_new" href="/admin/manage/topRated/create" class="btn green">
                                        Add New <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>
                                Organization
                            </th>
                            <th>
                                Drug
                            </th>
                            <th>
                                Created At
                            </th>
                            <th>
                                Actions
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tops as $top)
                            <tr class="odd gradeX">
                                <td>{{$top->storage->organization->name}}</td>
                                <td>{{$top->storage->drug->trade_name}}</td>
                                <td>{{$top->created_at}}</td>
                                <td>
                                    {!! Form::open(['url' => 'admin/manage/topRated/'.$top->id, 'method' => 'DELETE', 'class' => 'delete-form']) !!}
                                    <button title="Delete" type="submit"><i class="fa fa-remove"></i></button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection