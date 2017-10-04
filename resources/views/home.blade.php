@extends('layouts.main')
@section('title', config('app.name')." | ".Lang::get('main.home'))
@section('content')
    <section class="section-top-60">
        <div class="shell">
            <div class="range">
                <div class="cell-md-4 cell-sm-6">
                    <a href="category.html" class="thumbnail-variant-4 reveal-inline-block">
                        <img alt="" src="/images/index-04.jpg" width="370" height="670" class="img-responsive">
                    </a>
                </div>
                <div class="cell-md-4 cell-sm-6 cell-md-push-1">
                    <a href="category.html" class="thumbnail-variant-4 reveal-inline-block">
                        <img alt="" src="/images/index-07.jpg" width="370" height="670" class="img-responsive">
                    </a>
                </div>
                <div class="cell-md-4">
                    <div class="range">
                        <div class="cell-sm-6 cell-md-12">
                            <a href="category.html" class="thumbnail-variant-4 reveal-inline-block inset-md-bottom-7-p">
                                <img alt="" src="/images/index-05.jpg" width="370" height="320" class="img-responsive">
                            </a>
                        </div>
                        <div class="cell-sm-6 cell-md-12 offset-top-30 offset-sm-top-0">
                            <a href="category.html" class="thumbnail-variant-4 reveal-inline-block">
                                <img alt="" src="/images/index-06.jpg" width="370" height="320" class="img-responsive">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-top-60">
        <div class="shell">
            <h3>Browse Our Categories</h3>
            <hr class="divider divider-base divider-bold">
            <div class="range offset-top-30">
                <div class="cell-md-3 cell-xs-6">
                    <a href="category.html" class="thumbnail-variant-1">
                        <img alt="" src="images/index-08.jpg" width="270" height="363" class="img-responsive">
                        <div class="caption">
                            <h5 class="caption-title">Earrings</h5>
                            <p class="caption-descr">125 products</p>
                        </div>
                    </a>
                </div>
                <div class="offset-top-30 offset-xs-top-0 cell-md-3 cell-xs-6">
                    <a href="category.html" class="thumbnail-variant-1">
                        <img alt="" src="images/index-09.jpg" width="270" height="363" class="img-responsive">
                        <div class="caption">
                            <h5 class="caption-title">necklaces</h5>
                            <p class="caption-descr">546 products</p>
                        </div>
                    </a>
                </div>
                <div class="offset-top-30 offset-md-top-0 cell-md-3 cell-xs-6">
                    <a href="category.html" class="thumbnail-variant-1">
                        <img alt="" src="images/index-10.jpg" width="270" height="363" class="img-responsive">
                        <div class="caption">
                            <h5 class="caption-title">brooches</h5>
                            <p class="caption-descr">25 products</p>
                        </div>
                    </a>
                </div>
                <div class="offset-top-30 offset-md-top-0 cell-md-3 cell-xs-6">
                    <a href="category.html" class="thumbnail-variant-1">
                        <img alt="" src="images/index-11.jpg" width="270" height="363" class="img-responsive">
                        <div class="caption">
                            <h5 class="caption-title">rings</h5>
                            <p class="caption-descr">72 products</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
    <section class="section-top-60">
        <div class="shell">
            <h3>Weekly Featured Products</h3>
            <hr class="divider divider-base divider-bold">
            <!-- Owl Carousel-->
            <div data-mouse-drag="false" data-autoplay="true" data-md-items="4" data-sm-items="3" data-xs-items="2" data-margin="30" data-nav="true" class="owl-carousel offset-top-30">
                {{--<div class="product reveal-inline-block">--}}
                    {{--<div class="product-media"><a href="single-product.html"><img alt="" src="images/index-12.jpg" width="290" height="389" class="img-responsive"></a>--}}
                        {{--<div class="product-overlay"><a href="single-product.html" class="icon icon-circle icon-base fl-line-icon-set-shopping63"></a></div>--}}
                        {{--<div class="product-overlay-variant-2"><a href="category.html" class="label label-default">Featured</a></div>--}}
                    {{--</div>--}}
                    {{--<div class="offset-top-10">--}}
                        {{--<p class="big"><a href="single-product.html" class="text-base">6-mm Round Birthstone Stud Earrings</a></p>--}}
                    {{--</div>--}}
                    {{--<div class="product-price text-bold">$258.89</div>--}}
                    {{--<div class="product-actions elements-group-10">--}}
                        {{--<a href="#" class="icon mdi mdi-heart-outline icon-gray icon-sm"></a>--}}
                        {{--<a href="#" class="icon mdi mdi-signal icon-gray icon-sm"></a>--}}
                    {{--</div>--}}
                {{--</div>--}}
                @foreach($drugs as $drug)
                    <?php $drug_settings = json_decode($drug->storage->drug_settings); ?>
                    <div class="cell-md-4 cell-sm-6">
                        <div class="product reveal-inline-block">
                            <div class="product-media">
                                <a href="/search/?search={{$drug->storage->drug->trade_name}}">
                                    @if(isset($drug_settings->picture))
                                        <?php $picture = \App\Models\DrugPicture::where('id',$drug_settings->picture)->first(); ?>
                                        <img alt="" src="/assets/admin/images/drugs/{{$picture->name}}" width="290" height="389" class="img-responsive">
                                    @else
                                        <img alt="" src="/images/default_image.png" width="290" height="389" class="img-responsive">
                                    @endif
                                </a>
                                <div class="product-overlay "><a href="#"  data-storage-id="{{$drug->storage_id}}" data-token="{{csrf_token()}}" data-organization-id="{{$drug->storage->organization_id}}" class="add-product icon icon-circle icon-base fl-line-icon-set-shopping63"></a></div>
                            </div>
                            <div class="offset-top-10">
                                <a href="javascript:;" data-id="{{$drug->storage_id}}" class="get-drug-info">
                                    @if(App::getLocale() == 'am')
                                        <p class="big">{{$drug->storage->drug->trade_name}}<a href="single-product.html" class="text-base"> ({{$drug->storage->organization->name}})</a></p>
                                    @else
                                        @if(App::getLocale() == 'ru')
                                            <p class="big">{{$drug->storage->drug->trade_name_ru}}<a href="single-product.html" class="text-base">({{$drug->storage->organization->name}})</a></p>
                                        @elseif(App::getLocale() == 'en')
                                            <p class="big">{{$drug->storage->drug->trade_name_en}}<a href="single-product.html" class="text-base">({{$drug->storage->organization->name}})</a></p>
                                        @endif
                                    @endif
                                </a>

                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    <section class="section-top-60">
        <div style="background-image: url(images/index-16.jpg); background-repeat: no-repeat; background-size: cover;" class="shell well-variant-1">
            <h3>About Our Store</h3>
            <hr class="divider divider-base divider-bold">
            <p class="text-regular text-uppercase">We are offering you the unique goods because our product is the real treasure.</p>
            <p class="offset-top-20">If you are a true fan, you’ll love it. We have a tremendous variety in comparison to all of our competitors. Our collection is like a sea pearl among simple stones. Our devoted clients have noticed that our goods are the index of true, elegant taste.</p>
            <p></p>
        </div>
    </section>

    <section class="section-top-60 offset-md-top-0">
        <div class="shell">
            <div class="bg-primary section-60">
                <!-- Owl Carousel-->
                <div data-mouse-drag="false" data-items="1" data-drag="false" data-nav="true" data-dots="true" class="owl-nav-center owl-mobile-dots owl-nav-md owl-carousel">
                    <blockquote class="quote quote-variant-1"><img alt="" src="images/index-22.jpg" width="97" height="97" class="img-circle">
                        <h4 class="offset-top-20">
                            <q>&#34;I wanted to say thank you for the amazing product and for the fast processing and delivery. It was impressive, you weren't kidding.&#34;</q>
                        </h4>
                        <p>
                            <cite class="text-normal">&#8212; Rebecca Smith</cite>
                        </p>
                    </blockquote>
                    <blockquote class="quote quote-variant-1"><img alt="" src="images/index-21.jpg" width="97" height="97" class="img-circle">
                        <h4 class="offset-top-20">
                            <q>&#34;I loved everything about buying from you! My purchase was carefully packaged and quickly shipped. I was also pleased with great service and delivery times.&#34;</q>
                        </h4>
                        <p>
                            <cite class="text-normal">&#8212; Amanda Cooper</cite>
                        </p>
                    </blockquote>
                    <blockquote class="quote quote-variant-1"><img alt="" src="images/index-20.jpg" width="97" height="97" class="img-circle">
                        <h4 class="offset-top-20">
                            <q>&#34;WOW!!! I have no words! It was a unique and very enjoyable experience. You have such a diverse variety of beautiful products of the highest quality plus superb service.&#34;</q>
                        </h4>
                        <p>
                            <cite class="text-normal">&#8212; Bernard Show</cite>
                        </p>
                    </blockquote>
                </div>
            </div>
        </div>
    </section>
    <section class="section-60">
        <div class="shell text-left">
            <div class="range">
                <div class="cell-md-6">
                    <h3 class="text-center text-sm-left">New Products</h3>
                    <hr class="divider divider-sm-left divider-base divider-bold">
                        @foreach($new_products as $new_product)
                            <?php $drug_settings = json_decode($drug->drug_settings); ?>
                    <div class="range offset-top-20">
                        <div class="cell-md-12 cell-sm-4">
                            <div class="unit unit-horizontal unit-spacing-21">
                                <div class="unit-left"><a href="single-product.html">
                                        @if(isset($drug_settings->picture))
                                            <?php $picture = \App\Models\DrugPicture::where('id',$drug_settings->picture)->first(); ?>
                                            <img alt="" src="/assets/admin/images/drugs/{{$picture->name}}" width="100" height="100">
                                        @else
                                            <img alt="" src="/images/default_image.png" width="100" height="100">
                                        @endif
                                    </a>
                                </div>
                                <div class="unit-body">
                                    <div class="p">
                                        <a href="javascript:;" data-id="{{$new_product->id}}" class="get-drug-info">
                                            @if(App::getLocale() == 'am')
                                                {{$new_product->drug->trade_name}}
                                            @else
                                                @if(App::getLocale() == 'ru')
                                                    {{$new_product->drug->trade_name_ru}}
                                                @elseif(App::getLocale() == 'en')
                                                    {{$new_product->drug->trade_name_en}}
                                                @endif
                                            @endif
                                        </a>
                                    </div>
                                    <div class="offset-top-4">
                                        <div class="product-price text-bold">{{$new_product->price->price}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        @endforeach
                </div>

                <div class="cell-md-6 offset-top-45 offset-md-top-0">
                    <h3 class="text-center text-sm-left">Top Rated Products</h3>
                    <hr class="divider divider-sm-left divider-base divider-bold">
                    <div class="range offset-top-20">
                        @foreach($top_rated as $top)
                            <?php $drug_settings = json_decode($drug->storage->drug_settings); ?>
                        <div class="cell-md-12 cell-sm-4">
                            <div class="unit unit-horizontal unit-spacing-21">
                                <div class="unit-left">
                                    <a href="single-product.html">
                                        @if(isset($drug_settings->picture))
                                            <?php $picture = \App\Models\DrugPicture::where('id',$drug_settings->picture)->first(); ?>
                                            <img alt="" src="/assets/admin/images/drugs/{{$picture->name}}" width="100" height="100">
                                        @else
                                            <img alt="" src="/images/default_image.png" width="100" height="100">
                                        @endif
                                    </a>
                                </div>
                                <div class="unit-body">
                                    <div class="p">
                                        <a href="javascript:;" data-id="{{$new_product->id}}" class="get-drug-info">
                                            @if(App::getLocale() == 'am')
                                                {{$top->storage->drug->trade_name}}
                                            @else
                                                @if(App::getLocale() == 'ru')
                                                    {{$top->storage->drug->trade_name_ru}}
                                                @elseif(App::getLocale() == 'en')
                                                    {{$top->storage->drug->trade_name_en}}
                                                @endif
                                            @endif
                                        </a>
                                    </div>
                                    <div class="offset-top-4">
                                        <div class="product-price text-bold">{{$new_product->price->price}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if (session('ticket'))
        <div id="createTicketSuccessfully" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <span>{{session('ticket')}}</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('main.close')}}</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection