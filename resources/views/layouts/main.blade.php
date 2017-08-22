<!DOCTYPE html>
<html lang="en" class="wide wow-animation">
<head>
    <!-- Site Title-->
    <title>@yield('title')</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta charset="utf-8">
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">
    <!-- Stylesheets-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Playfair+Display:400,700,900,400italic,700italic%7CRoboto:400,300,100,700,300italic,400italic,700italic%7CMontserrat:400,700">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="/assets/admin/plugins/clockface/css/clockface.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/admin/plugins/bootstrap-datepicker/css/datepicker3.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/admin/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/admin/plugins/bootstrap-colorpicker/css/colorpicker.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/admin/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css"/>
    <link rel="stylesheet" type="text/css" href="/assets/admin/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
        .chat{
            background-color:#e6e6e6;
            height:200px;
            overflow-y: auto;
        }
        .chat .message{
            padding: 5px;
            font-size:15px
        }
    </style>
    <!--[if lt IE 10]>
    <div style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
    <script src="/assets/js/html5shiv.min.js"></script>
    <![endif]-->

</head>

<body>

<!-- Page-->
<div class="page text-center">

    <!-- Page Header-->
    <header class="page-header">
        <!-- RD Navbar-->
        <div class="rd-navbar-wrap">
            <nav data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fullwidth" data-lg-layout="rd-navbar-static" class="rd-navbar" data-stick-up-offset="50" data-md-layout="rd-navbar-fullwidth">
                <div class="rd-navbar-toppanel">
                    <div class="rd-navbar-toppanel-inner">
                        <div class="rd-navbar-toppanel-submenu"><a href="#" data-rd-navbar-toggle=".rd-navbar-toppanel-submenu" class="rd-navbar-toppanel-submenu-toggle"></a>
                            <ul>
                                @if(Auth::check())
                                <li><a href="/account">{{Lang::get('main.myAccount')}}</a></li>
                                @endif
                            </ul>
                        </div>

                        <div class="rd-navbar-toppanel-wrapper">
                            <div class="rd-navbar-contact-info">
                                @if(Auth::check())
                                <a href="/logout" class="btn btn-primary offset-xs-left-10 offset-top-10 offset-xs-top-0 offset-md-top-10 offset-lg-top-0">{{Lang::get('main.signout')}}</a>
                                @else
                                <button type="button" data-toggle="modal" data-target="#signIn" class="btn btn-primary offset-xs-left-10 offset-top-10 offset-xs-top-0 offset-md-top-10 offset-lg-top-0">{{Lang::get('main.signin')}}</button>
                                @endif
                            </div>
                            <div class="rd-navbar-toppanel-search">
                                <!-- RD Navbar Search-->
                                <div class="rd-navbar-search-wrap">
                                    <div class="rd-navbar-search">
                                        {!! Form::open(['url' => '/search','method' => 'GET', 'class' => 'search rd-navbar-search-form']) !!}
                                            <label class="rd-navbar-search-form-input">
                                                <input type="text" name="search" placeholder="{{Lang::get('main.search')}}..." autocomplete="off">
                                            </label>
                                            <button type="submit" class="rd-navbar-search-form-submit"></button>
                                            <div data-rd-navbar-toggle=".rd-navbar-search" class="rd-navbar-search-toggle"></div>
                                        {!! Form::close() !!}
                                        <span class="rd-navbar-live-search-results"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="rd-navbar-currency"><a data-rd-navbar-toggle=".rd-navbar-currency" href="#">{{ Config::get('languages')[App::getLocale()] }}</a>
                                <ul>
                                    @foreach (Config::get('languages') as $lang => $language)
                                        @if ($lang != App::getLocale())
                                            <li>
                                                <a href="{{ route('lang.switch', $lang) }}">{{$language}}</a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="rd-navbar-inner">
                    <!-- RD Navbar Panel-->
                    <div class="rd-navbar-panel">
                        <!-- RD Navbar Toggle-->
                        <button data-rd-navbar-toggle=".rd-navbar-nav-wrap" class="rd-navbar-toggle"><span></span></button>
                        <!-- RD Navbar Brand-->
                        <div class="rd-navbar-brand"><a href="/" class="brand-name"><img alt="" src="/assets/images/logo.png"></a></div>
                        <div class="rd-navbar-elements-wrap text-right">
                            @if(!Auth::check())
                                <ul class="rd-navbar-socials elements-group-18 reveal-inline-block text-middle">
                                    <li><a href="/login/facebook" class="text-gray icon icon-xs fa-facebook"></a></li>
                                    <li><a href="/login/twitter" class="text-gray icon icon-xs fa-twitter"></a></li>
                                    <li><a href="/login/google" class="text-gray icon icon-xs fa-google-plus"></a></li>
                                </ul>
                            @endif
                            @if(Auth::check())
                            <div class="rd-navbar-message message-block text-middle text-left">
                                <div class="rd-navbar-message-toggle shop-block-header">
                                    <a href="#" data-rd-navbar-toggle=".rd-navbar-message" class="text-middle icon icon-primary">
                                        <i class="fa fa-envelope"></i>
                                    </a>
                                    <span class="text-middle shop-products-count label label-circle label-primary">{{count($messages)}}</span>
                                </div>
                                <div class="rd-navbar-message-panel shop-block-body">
                                    <h4>{{Lang::get('main.notifications')}}</h4>
                                    <div>
                                        @foreach($messages as $message)
                                        <hr class="divider divider-gray divider-offset-20">
                                        <div class="unit unit-spacing-15 unit-horizontal rd-navbar-shop-product" >
                                            <div class="unit-body p"><a href="/order/details" class="text-dark">{{$message['name']}}</a>
                                                <p><a href="/order/details"><span class="big text-regular text-primary text-spacing-40 basket-product-price">{{$message['message']}}</span></a></p>
                                            </div>
                                        </div>
                                        <hr class="divider divider-gray divider-offset-20">
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="rd-navbar-shop shop-block text-middle text-left">
                                <div class="rd-navbar-shop-toggle shop-block-header">
                                    <a href="#" data-rd-navbar-toggle=".rd-navbar-shop" class="text-middle icon icon-primary fl-line-icon-set-shopping63"></a>
                                    @if(session('order'))
                                    <span class="text-middle shop-products-count label label-circle label-primary">{{count(session('order'))}}</span>
                                    @endif
                                </div>
                                <div class="rd-navbar-shop-panel shop-block-body">
                                    <h4>{{Lang::get('main.mycart')}}</h4>
                                    <div class="shop-block-products" data-organization-id="{{session('order') ? session('order')[0]['organization_id'] : ''}}">
                                        @if(session('order'))
                                            <?php
                                            $all_prices = 0;
                                            ?>
                                            @foreach(session('order') as $order)
                                                <?php
                                                $all_prices += $order['price']*$order['count'];
                                                ?>
                                                <div class="unit unit-spacing-15 unit-horizontal rd-navbar-shop-product" data-id="{{$order['storage_id']}}">
                                                    <div class="unit-left">
                                                        <a href="javascript:;" class="text-dark"><img alt="" height="50" width="50" src="{{$order['image']}}"></a>
                                                        </div>
                                                    <div class="unit-body p"><a href="javascript:;" class="text-dark">{{$order['name']}}</a>
                                                        <p>{{$order['count']}} x <span class="big text-regular text-primary text-spacing-40 basket-product-price">{{$order['price']}}</span></p>
                                                        <a href="javascript:;" data-count="{{$order['count']}}" class="delete-basket-product" data-token="{{csrf_token()}}" data-id="{{$order['storage_id']}}"><span onclick="delete_basket_product(this)" class="rd-navbar-shop-product-delete icon mdi mdi-close"></span></a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <hr class="divider divider-gray divider-offset-20">
                                    <h4>Subtotal: <span class="text-regular text-primary text-normal text-spacing-40 basket-subtotal">{{session('order') ? $all_prices : 0}}</span></h4>
                                    <a href="/order/cart" class="btn btn-block btn-default">{{Lang::get('main.viewCart')}}</a>
                                    <a href="/order/checkout" class="btn btn-block btn-primary">{{Lang::get('main.checkout')}}</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="rd-navbar-nav-wrap">
                        <!-- RD Navbar Nav-->
                        <ul class="rd-navbar-nav">
                            @if(!Auth::check())
                            <li class="veil rd-navbar-fixed--visible"><a href="#" data-toggle="modal" data-target="#signIn">{{Lang::get('main.signin')}}</a></li>

                            @endif
                            <li><a href="/">{{Lang::get('main.home')}}</a></li>
                            <li><a href="/order">{{Lang::get('main.createOrder')}}</a></li>
                            <li><a href="/order/details">{{Lang::get('main.orderDetails')}}</a></li>
                            <li class="veil rd-navbar-fixed--visible"><a href="/order/cart">{{Lang::get('main.mycart')}}</a></li>
                            @if(Auth::check())
                            <li class="veil rd-navbar-fixed--visible"><a href="/logout">{{Lang::get('main.logout')}}</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <!-- Page Content-->
    <!-- Page Content-->
    <main class="page-content">
        @yield('content')
    </main>
    <!-- Page Footer-->
    <footer class="page-footer section-60">
        <div class="shell"><a href="/" class="brand"><img alt="" src="/assets/images/logo.png" width="163" height="41" class="reveal-inline-block img-responsive"></a>
            <p>Our products are a combination of classic and modern style; we can satisfy any demands of customers, that is why we have so many fans. You will <br class='veil reveal-lg-block'> always be popular with our jewelry; the magical shine of our products will bring you the best of luck!</p>
            <ul class="elements-group-20 offset-top-20">
                <li><a href="#" class="icon icon-xs text-base fa-facebook"></a></li>
                <li><a href="#" class="icon icon-xs text-base fa-twitter"></a></li>
                <li><a href="#" class="icon icon-xs text-base fa-google-plus"></a></li>
                <li><a href="#" class="icon icon-xs text-base fa-linkedin"></a></li>
                <li><a href="#" class="icon icon-xs text-base fa-pinterest"></a></li>
            </ul>
            <p class="offset-top-20 text-muted"><span class='text-bold'>Turquoise</span> 2016 | <a href='privacy.html'>Privacy Policy</a></p>
        </div>
    </footer>
    <!-- FOOTER LINK-->
</div>
<!-- Modal -->
<div id="signIn" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{Lang::get('main.signin')}}</h4>
            </div>
            <form id="signInForm">
                {{ csrf_field() }}
                <div class="modal-body">
                    <label class="error error-login"></label>
                    <input type="text" name="email" placeholder="{{Lang::get('main.email')}} *" class="form-control">
                    <input type="password" name="password" placeholder="{{Lang::get('main.password')}} *" class="form-control">
                    <a href="/password/reset">{{Lang::get('main.forgotPassword')}}</a>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary offset-top-20">{{Lang::get('main.signin')}}</button>
                    <button type="button" class="btn btn-default sign-up-button" data-dismiss="modal">{{Lang::get('main.signup')}}</button>
                </div>
            </form>
        </div>

    </div>
</div>
<div id="signUp" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{Lang::get('main.signup')}}</h4>
            </div>
            <form id="signUpForm">
                {{ csrf_field() }}
                <div class="modal-body">
                    <label class="error error-register"></label>
                    <input type="text" name="name" placeholder="{{Lang::get('main.name')}} *" class="form-control">
                    <input type="text" name="email" placeholder="{{Lang::get('main.email')}} *" class="form-control">
                    <input type="password" name="password" id="password" placeholder="{{Lang::get('main.password')}} *" class="form-control">
                    <input type="password" name="password_confirmation" placeholder="{{Lang::get('main.confirmPassword')}} *" class="form-control">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary offset-top-20">{{Lang::get('main.signup')}}</button>
                    <button type="button" class="btn btn-default sign-in-button" data-dismiss="modal">{{Lang::get('main.signin')}}</button>
                </div>
            </form>
        </div>

    </div>
</div>
<div id="chooseMethodPayModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{Lang::get('main.choosePayMethod')}}</h4>
            </div>
            <div class="modal-body">
                <button class="btn btn-info" data-dismiss="modal">{{Lang::get('main.credit')}}</button>
                <button class="btn btn-info choose-pay-method" data-dismiss="modal">{{Lang::get('main.inplace')}}</button>
            </div>
        </div>

    </div>
</div>
<div id="chooseTypePayModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{Lang::get('main.choosePayType')}}</h4>
            </div>
            <div class="modal-body">
                <form>
                    {{ csrf_field() }}
                    <input type="hidden" id="delivery" value="{{\App\Models\UserOrder::DELIVERY}}">
                    <input type="hidden" id="pharmacy" value="{{\App\Models\UserOrder::PHARMACY}}">
                    <button type="button" class="btn btn-info choose-pay-type"  data-dismiss="modal" data-id="{{\App\Models\UserOrder::DELIVERY}}">{{Lang::get('main.delivery')}}</button>
                    <button type="button" class="btn btn-info choose-pay-type" data-dismiss="modal" data-method="{{\App\Models\UserOrder::INPLACE}}" data-id="{{\App\Models\UserOrder::PHARMACY}}">{{Lang::get('main.takeFromPharmacy')}}</button>
                </form>
            </div>
        </div>

    </div>
</div>
<div id="paySendModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{Lang::get('main.deliveryAddress')}}</h4>
            </div>
            <div class="modal-body">
                <form id="delivery_address_form">
                    {{ csrf_field() }}
                    <input type="hidden" name="payment_method" value="{{\App\Models\UserOrder::INPLACE}}">
                    <input type="hidden" name="payment_type" value="">
                    <input type="hidden" value="" name="type">
                    <input type="text" class="form-control" id="delivery_address" name="delivery_address" placeholder="{{Lang::get('main.enterDeliveryAddress')}}">
                    <input type="text" class="form-control" id="order_take_time" name="order_take_time" placeholder="{{Lang::get('main.enterTakeTime')}}">
                    <button class="btn btn-default">{{Lang::get('main.send')}}</button>
                </form>
            </div>
        </div>

    </div>
</div>
<div id="orderPayFinishModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{Lang::get('main.success')}}</h4>
            </div>
            <div class="modal-body">
                <span style="font-size: 20px;">{{Lang::get('main.orderPaySuccess')}}</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('main.close')}}</button>
            </div>
        </div>

    </div>
</div>
@if($errors->has('social_email_exists'))
<div id="errorModal" class="modal-sm fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{Lang::get('main.error')}}</h4>
            </div>
            <div class="modal-body">
                <span class="error">{{$errors->first()}}</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('main.close')}}</button>
            </div>
        </div>

    </div>
</div>
@endif
@if(session('orderDetails'))
    <div id="orderFinishModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{Lang::get('main.success')}}</h4>
                </div>
                <div class="modal-body">
                    <span style="font-size: 20px;">{!! session('orderDetails') !!}</span>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('main.close')}}</button>
                </div>
            </div>

        </div>
    </div>
@endif
<div id="acceptOrganizationModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{Lang::get('main.accept')}}</h4>
            </div>
            <div class="modal-body">
                <h4>{{Lang::get('main.acceptOrganizationMessage')}}</h4>
                <p style="font-size: 30px;" class="organization-name"></p>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary continue-button">{{Lang::get('main.continue')}}</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('main.close')}}</button>
            </div>
        </div>
    </div>
</div>
<div id="errorPorductOrganizationModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{Lang::get('main.error')}}</h4>
            </div>
            <div class="modal-body">
                <span class="error">{{Lang::get('main.productOrganizationError')}}</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('main.close')}}</button>
            </div>
        </div>
    </div>
</div>
<div id="errorPorductExist" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{Lang::get('main.error')}}</h4>
            </div>
            <div class="modal-body">
                <span class="error">{{Lang::get('main.errorPorductExist')}}</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{Lang::get('main.close')}}</button>
            </div>
        </div>
    </div>
</div>
<!-- Java script-->
<script src="http://maps.google.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyBgAEkAL2phbCyMlJVqPYzhcG9cg4gIItU"
        type="text/javascript"></script>
<script src="/assets/js/core.min.js"></script>
<script type="text/javascript" src="/assets/admin/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/assets/admin/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="/assets/admin/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
<script type="text/javascript" src="/assets/admin/plugins/clockface/js/clockface.js"></script>
<script type="text/javascript" src="/assets/admin/plugins/bootstrap-daterangepicker/moment.min.js"></script>
<script type="text/javascript" src="/assets/admin/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript" src="/assets/admin/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script type="text/javascript" src="/assets/admin/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<script src="/assets/js/main.js"></script>
<script src="/assets/js/cart.js"></script>
<script src="/assets/js/order.js"></script>
</body>
</html>