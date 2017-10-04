@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box grey-cascade">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-user"></i>Tickets
                    </div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped table-bordered ticket-table table-hover">
                        <thead>
                        <tr>
                            <th>
                                Name
                            </th>
                            <th>
                                Email
                            </th>
                            <th>
                                Message
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($tickets as $ticket)
                            <tr class="odd gradeX">
                                <td>{{$ticket->name}}</td>
                                <td>{{$ticket->email}}</td>
                                <td>{{$ticket->message}}</td>
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