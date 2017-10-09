@extends('layouts.main')
@section('title', config('app.name')." | ".Lang::get('main.search'))
@section('content')
    <div class="shell">
        <div>
            <ol class="breadcrumb">
                <li><a href="/" class="icon icon-sm fa-home text-primary"></a></li>
                <li class="active">Search
                </li>
            </ol>
        </div>
    </div>

    <div class="shell section-bottom-60">
        <div class="range">
            <div class="cell-md-12">


                <div class="range">
                    <div class="cell-md-4">
                        <div class="form-group select-filter">
                            {!! Form::open(['url' => '/search/'.$organization_id,'method' => 'GET', 'class' => 'search rd-navbar-search-form search-form']) !!}
                            <input class="form-control" value="{{session('search') ? session('search') : Input::old('search')}}" placeholder="{{session('search') ? session('search') : Lang::get('main.searchFor')." ".$organization->name}}" name="search">
                            {!! Form::close() !!}

                            {{--<select data-placeholder="Select an option" data-minimum-results-for-search="Infinity">--}}
                                {{--<option>Default sorting</option>--}}
                                {{--<option>Sort by popularity</option>--}}
                                {{--<option>Sort by average rating</option>--}}
                                {{--<option>Sort by newness</option>--}}
                                {{--<option>Sort by price: low to high</option>--}}
                                {{--<option>Sort by price: high to low</option>--}}
                            {{--</select>--}}
                        </div>
                    </div>
                    <div class="cell-md-2">
                        <button class="btn btn-info pull-left search-button">{{Lang::get('main.search')}}</button>
                    </div>
                    <div class="cell-md-6 cell-middle text-md-right ">
                        <h6 class="">Showing all <span class='text-primary'>{{count($drugs)}} results</span></h6>
                    </div>
                </div>
                <div class="range offset-top-30">
                    <!-- Product-->
                    @foreach($drugs as $drug)
                    <?php $drug_settings = json_decode($drug->drug_settings); ?>
                    <div class="cell-md-4 cell-sm-6">
                        <div class="product reveal-inline-block">
                            <div class="product-media">
                                <a href="/search/?search={{$drug->trade_name}}">
                                    @if(isset($drug_settings->picture))
                                        <?php $picture = \App\Models\DrugPicture::where('id',$drug_settings->picture)->first(); ?>
                                        <img alt="" src="/assets/admin/images/drugs/{{$picture->name}}" width="290" height="389" class="img-responsive">
                                    @else
                                    <img alt="" src="/images/default_image.png" width="290" height="389" class="img-responsive">
                                    @endif
                                </a>
                                <div class="product-overlay "><a href="#"  data-storage-id="{{$drug->storage_id}}" data-token="{{csrf_token()}}" data-organization-id="{{$drug->id}}" class="add-product icon icon-circle icon-base fl-line-icon-set-shopping63"></a></div>
                            </div>
                            <div class="offset-top-10">
                                <div class="clearfix reveal-xs-flex reveal-sm-block range-justify">
                                    <div class="stepper">
                                        <input type="number" data-zeros="true" value="1" min="1" max="10" class="form-control form-control-impressed stepper-input">
                                        <span class="stepper-arrow up"></span>
                                        <span class="stepper-arrow down"></span>
                                    </div>
                                </div>
                                <a href="javascript:;" data-id="{{$drug->storage_id}}" class="get-drug-info">
                                    @if(App::getLocale() == 'am')
                                    <p class="big">{{$drug->trade_name}}<a href="javascript:;" class="text-base" data-id="{{$drug->storage_id}}" onclick="organization_map(this)"> ({{$drug->name}})</a></p>
                                    @else
                                        @if(App::getLocale() == 'ru')
                                            <p class="big">{{$drug->trade_name_ru}}<a href="javascript:;" data-id="{{$drug->storage_id}}" class="text-base" onclick="organization_map(this)">({{$drug->name}})</a></p>
                                        @elseif(App::getLocale() == 'en')
                                            <p class="big">{{$drug->trade_name_en}}<a href="javascript:;" data-id="{{$drug->storage_id}}" class="text-base" onclick="organization_map(this)">({{$drug->name}})</a></p>
                                        @endif
                                    @endif
                                </a>

                            </div>
                                <div class="product-price text-bold">
                                    {{$drug->price}}
                                </div>

                            {{--<div class="product-rating">--}}
                                {{--<div><span class="icon icon-xs mdi mdi-star"></span><span class="icon icon-xs mdi mdi-star"></span><span class="icon icon-xs mdi mdi-star"></span><span class="icon icon-xs mdi mdi-star"></span><span class="icon icon-xs mdi mdi-star text-gray-light"></span></div>--}}
                            {{--</div>--}}
                            {{--<div class="product-actions elements-group-10"><a href="#" class="icon mdi mdi-heart-outline icon-gray icon-sm"></a><a href="#" class="icon mdi mdi-signal icon-gray icon-sm"></a></div>--}}
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="text-md-left offset-top-45">
                </div>
            </div>
        </div>
    </div>

@endsection