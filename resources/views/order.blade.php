@extends('layouts.main')
@section('title', config('app.name')." | ".Lang::get('main.createOrder'))
@section('content')
    <style>
        #radioBtn .notActive{
            color: #7fcbc9 !important;
            background-color: #fff !important;
        }
        #radioBtn .active{
            color: #ffffff !important;
            background-color: #7fcbc9 !important;
            border: 1px solid #7fcbc9;
        }
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
    <!-- Latest compiled and minified CSS -->
    <div class="shell">
        <div>
            <ol class="breadcrumb">
                <li><a href="/" class="icon icon-sm fa-home text-primary"></a></li>
                <li class="active">{{Lang::get('main.select_pharmacy')}}
                </li>
            </ol>
        </div>
    </div>
    <div class="shell section-bottom-60 offset-top-4">
        <div class="row">
            <div class="form-group">
                <div class="col-sm-7 col-md-7">
                    <div class="input-group">
                        <div id="radioBtn" class="btn-group">
                            <a class="btn btn-primary btn-sm active" data-toggle="typeOrg" data-title="select">{{Lang::get('main.in_map')}}</a>
                            <a class="btn btn-primary btn-sm notActive" data-toggle="typeOrg" data-title="choose">{{Lang::get('main.in_list')}}</a>
                        </div>
                        <input type="hidden" name="typeOrg" id="typeOrg">
                    </div>
                </div>
            </div>
        </div>
        <div class="section-bottom-60"></div>

        <div class="row" data-toggle="typeOrg" data-title="select">
            <input id="address" class="controls form-control" type="text" placeholder="Search Box">
            <div id="map"></div>
        </div>
        <div class="row" data-toggle="typeOrg" data-title="choose" style="display:none">
            <div class="col-sm-3">
                <div class="form-group">
                    <select class="choose-organization-list" data-placeholder="{{Lang::get('main.select')}}...">
                        @foreach($organizations as $organization)
                        <option value="{{$organization->id}}">{{$organization->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-4">
                <button class="btn btn-default pull-left choose-organization-button">{{Lang::get('main.choose')}}</button>
            </div>
        </div>
    </div>
@endsection