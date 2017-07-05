@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box grey-cascade">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-user"></i>Managed Drugs
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
                                    <a id="sample_editable_1_new" href="/admin/manage/drugs/create" class="btn green">
                                        Add New <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>Trade Name торговое название (Առևտրային անվանում)</th>
                            <th>Generic Name вещество (Ազդող նյութ)</th>
                            <th>Dosage Form форма (Դեղաձև)</th>
                            <th>Dosage Strength дозировка (Դեղաչափ)</th>
                            <th>Code</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($drugs as $drug)
                            <tr class="odd gradeX">
                                <td>{{$drug->trade_name}}</td>
                                <td>{{$drug->generic_name}}</td>
                                <td>{{$drug->dosage_form}}</td>
                                <td>{{$drug->dosage_strength}}</td>
                                <td>{{$drug->code}}</td>
                                <td>{{$drug->created_at}}</td>
                                <td>
                                    {!! Form::open(['url' => 'admin/manage/drugs/'.$drug->id, 'method' => 'DELETE', 'class' => 'delete-form']) !!}
                                    <a href="/admin/manage/drugs/{{$drug->id}}/edit" title="Edit"><i class="fa fa-pencil"></i></a>
                                    <button title="Delete" type="submit"><i class="fa fa-remove"></i></button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                        {{ $drugs->links() }}
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>
@endsection