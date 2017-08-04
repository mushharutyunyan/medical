@extends('layouts.main')

@section('content')
    <div class="shell">
        <div>
            <ol class="breadcrumb">
                <li><a href="/" class="icon icon-sm fa-home text-primary"></a></li>
                <li class="active">{{Lang::get('main.account')}}
                </li>
            </ol>
        </div>
    </div>
    <div class="shell section-bottom-60">
        <div class="range">
            <div class="cell-md-8 text-xs-left">
                <h4>{{Lang::get('main.accountInfo')}}</h4>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
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
                {{ Form::model(Auth::user(), ['url' => '/account/update/'.Auth::user()['id'], 'method' => 'PUT', 'class' => 'offset-top-20 rd-mailform']) }}
                    {{ csrf_field() }}
                    <label for="name" class="text-italic">{{Lang::get('main.name')}}:<span class="text-primary">*</span></label>
                    <input id="name" type="text" name="name" value="{{Input::old('name') ? Input::old('name') : Auth::user()['name']}}">
                    <label for="email" class="text-italic">{{Lang::get('main.email')}}:<span class="text-primary">*</span></label>
                    <input id="email" type="text" name="email" data-constraints="" value="{{Input::old('email') ? Input::old('email') : Auth::user()['email']}}">
                    <button class="btn btn-primary">{{Lang::get('main.send')}}</button>
                </form>
            </div>
        </div>
    </div>
@endsection