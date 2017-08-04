@extends('layouts.main')

@section('content')
    <div class="shell">
        <div>
            <ol class="breadcrumb">
                <li><a href="/" class="icon icon-sm fa-home text-primary"></a></li>
                <li class="active">{{Lang::get('main.resetPassword')}}
                </li>
            </ol>
        </div>
    </div>
    <div class="shell section-bottom-60">
        <div class="range">
            <div class="cell-md-8 text-xs-left">
                <h4>Reset Password</h4>
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form class="offset-top-20 rd-mailform" role="form" method="POST" action="{{ url('/password/email') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <div class="col-md-6">
                            <input id="email" type="email" placeholder="{{Lang::get('main.email')}}" class="form-control" name="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">{{Lang::get('main.resetPasswordButton')}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection