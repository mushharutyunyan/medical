@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet box grey-cascade">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-user"></i>Messages
                    </div>
                </div>
                <div class="portlet-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                        <div class="tab-content">

                            <div class="tab-pane active" id="tab_1_6">
                                <div class="row">
                                    <div class="col-md-3">
                                        <ul class="ver-inline-menu tabbable margin-bottom-10">
                                            @foreach($admins as $admin)
                                            <?php $active = '' ?>
                                            @if($id == $admin->id)
                                                <?php $active = 'active' ?>
                                            @endif
                                            <li class="current-chat {{$active}}" data-id="{{$admin->id}}" data-child-tab="tab_{{$admin->id}}">
                                                <a data-toggle="tab" href="#tab_{{$admin->id}}" aria-expanded="true">
                                                    <i class="fa fa-envelope"></i> {{$admin->firstname}} {{$admin->lastname}} - {{$admin->organization->name}} </a>
                                                <span class="after">
													</span>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="tab-content">
                                            @foreach($admins as $admin)
                                                <?php $active = '' ?>
                                                @if($id == $admin->id)
                                                <?php $active = 'active' ?>
                                                @endif
                                            <div id="tab_{{$admin->id}}" class="tab-pane {{$active}}">
                                                <div class="portlet light ">
                                                    <div class="portlet-title">
                                                        <div class="caption">
                                                            <i class="icon-bubble font-red-sunglo"></i>
                                                            <span class="caption-subject font-red-sunglo bold uppercase">{{$admin->firstname}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <div class="loading" style="display:none">
                                                            <img src="/assets/admin/img/loader-drugs.gif">
                                                        </div>
                                                        <div class="scroller" style="height: 353px;" data-always-visible="1" data-rail-visible1="1">
                                                            <ul class="chats">
                                                                @if(!empty($active))
                                                                    @foreach($messages as $message)
                                                                        <?php $row_class = 'out' ?>
                                                                        @if($message->from == $id)
                                                                        <?php $row_class = 'in' ?>
                                                                        @endif
                                                                        <li class="{{$row_class}}">
                                                                            <div class="message">
                                                                                <span class="arrow"></span>
                                                                                <a href="#" class="name"></a>
                                                                                <span class="datetime">{{$message->created_at}}</span>
                                                                                <span class="body">{{$message->message}}</span>
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                @endif
                                                            </ul>
                                                        </div>
                                                        <div class="chat-form">
                                                            {!! Form::open(['class' => 'add-chat-message','data-tab' => 'tab_'.$admin->id]) !!}
                                                            <div class="input-cont">
                                                                <input type="hidden" value="{{$admin->id}}" name="partner_id">
                                                                <input class="form-control" name="message" type="text" placeholder="Type a message here..."/>
                                                            </div>
                                                            <div class="btn-cont">
                                                                <span class="arrow">
                                                                </span>
                                                                <button class="btn blue icn-only">
                                                                    <i class="fa fa-check icon-white"></i>
                                                                </button>
                                                            </div>
                                                            {!! Form::close() !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
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