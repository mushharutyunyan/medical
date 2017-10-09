@extends('layouts.main')
@section('title', config('app.name')." | ".Lang::get('main.home'))
@section('content')
    <div class="shell section-bottom-60 section-top-60">
        <div class="range">
            <div class="cell-md-8 text-xs-left">
                <h4>{{Lang::get('main.contact_info')}}</h4>
                <p>{{Lang::get('main.contact_info_messages')}}</p>
                <dl class="list-terms">
                    <dt>{{Lang::get('main.address')}}</dt>
                    <dd>The Company Name Inc. 9870 St Vincent Place, Glasgow, DC 45 Fr 45.</dd>
                </dl>
                <dl class="list-terms">
                    <dt>{{Lang::get('main.telephone')}}</dt>
                    <dd><a href="callto:#" class="text-base">+1 800 603 6035</a></dd>
                </dl>
                <dl class="list-terms">
                    <dt>{{Lang::get('main.email')}}</dt>
                    <dd><a href="mailto:#">mail@demolink.org</a></dd>
                </dl>
                <hr class="divider divider-offset-lg divider-gray">
                <h4>{{Lang::get('main.contact_form')}}</h4>
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul class="list-group">
                            @foreach ($errors->all() as $error)
                                <li class="list-group-item">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- RD Mailform-->
                {!! Form::open(['url' => '/ticket',"class" => "offset-top-20 rd-mailform", "data-result-class" => "rd-mailform-validate", 'data-form-type' => 'contact']) !!}
                    <label for="name" class="text-italic">{{Lang::get('main.your')}} {{Lang::get('main.name')}}:<span class="text-primary">*</span></label>
                    <input id="name" type="text" name="name" value="{{old('name')}}" >
                    <label for="email" class="text-italic">{{Lang::get('main.your')}} {{Lang::get('main.email')}}:<span class="text-primary">*</span></label>
                    <input id="email" type="text" name="email" value="{{old('email')}}" >
                    <label for="message" class="text-italic">{{Lang::get('main.your')}} {{Lang::get('main.messages')}}:<span class="text-primary">*</span></label>
                    <textarea id="message" name="message" >{{old('message')}} </textarea>
                    <button class="btn btn-primary">{{Lang::get('main.send')}}</button>
                {{Form::close()}}
                <!-- Rd Mailform result field-->
                <div class="rd-mailform-validate"></div>
            </div>
        </div>
    </div>
@endsection