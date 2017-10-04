@extends('layouts.main')
@section('title', config('app.name')." | ".Lang::get('main.home'))
@section('content')
    <div class="shell section-bottom-60 section-top-60">
        <div class="range">
            <div class="cell-md-8 text-xs-left">
                <h4>Contact info</h4>
                <p>We are always ready to help you. There are many ways to contact us. You may drop us a line, give us a call or send an email, choose what suits you most.</p>
                <dl class="list-terms">
                    <dt>Address</dt>
                    <dd>The Company Name Inc. 9870 St Vincent Place, Glasgow, DC 45 Fr 45.</dd>
                </dl>
                <dl class="list-terms">
                    <dt>Telephone</dt>
                    <dd><a href="callto:#" class="text-base">+1 800 603 6035</a></dd>
                </dl>
                <dl class="list-terms">
                    <dt>FAX</dt>
                    <dd><a href="callto:#" class="text-base">+1 800 889 9898</a></dd>
                </dl>
                <dl class="list-terms">
                    <dt>E-mail</dt>
                    <dd><a href="mailto:#">mail@demolink.org</a></dd>
                </dl>
                <hr class="divider divider-offset-lg divider-gray">
                <h4>Contact form</h4>
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
                    <label for="name" class="text-italic">Your Name:<span class="text-primary">*</span></label>
                    <input id="name" type="text" name="name" value="{{old('name')}}" >
                    <label for="email" class="text-italic">Your E-mail:<span class="text-primary">*</span></label>
                    <input id="email" type="text" name="email" value="{{old('email')}}" >
                    <label for="message" class="text-italic">Your Message:<span class="text-primary">*</span></label>
                    <textarea id="message" name="message" >{{old('message')}} </textarea>
                    <button class="btn btn-primary">Send</button>
                {{Form::close()}}
                <!-- Rd Mailform result field-->
                <div class="rd-mailform-validate"></div>
            </div>
        </div>
    </div>
@endsection