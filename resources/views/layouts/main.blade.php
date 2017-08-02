<!DOCTYPE html>
<html lang="en" class="wide wow-animation">
<head>
    <!-- Site Title-->
    <title>Home</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta charset="utf-8">
    <link rel="icon" href="/assets/images/favicon.ico" type="image/x-icon">
    <!-- Stylesheets-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Playfair+Display:400,700,900,400italic,700italic%7CRoboto:400,300,100,700,300italic,400italic,700italic%7CMontserrat:400,700">
    <link rel="stylesheet" href="/assets/css/style.css">
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
                                <li><a href="/account">My Account</a></li>
                                @endif
                            </ul>
                        </div>
                        <div class="rd-navbar-toppanel-wrapper">
                            <div class="rd-navbar-contact-info">
                                @if(Auth::check())
                                <a href="/logout" class="btn btn-primary offset-xs-left-10 offset-top-10 offset-xs-top-0 offset-md-top-10 offset-lg-top-0">Log out</a>
                                @else
                                <button type="button" data-toggle="modal" data-target="#signIn" class="btn btn-primary offset-xs-left-10 offset-top-10 offset-xs-top-0 offset-md-top-10 offset-lg-top-0">Sign In</button>
                                @endif
                            </div>
                            <div class="rd-navbar-toppanel-search">
                                <!-- RD Navbar Search-->
                                <div class="rd-navbar-search-wrap">
                                    <div class="rd-navbar-search">
                                        <form action="search.php" method="GET" class="rd-navbar-search-form">
                                            <label class="rd-navbar-search-form-input">
                                                <input type="text" name="s" placeholder="Search..." autocomplete="off">
                                            </label>
                                            <button type="submit" class="rd-navbar-search-form-submit"></button>
                                            <div data-rd-navbar-toggle=".rd-navbar-search" class="rd-navbar-search-toggle"></div>
                                        </form><span class="rd-navbar-live-search-results"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="rd-navbar-currency"><a data-rd-navbar-toggle=".rd-navbar-currency" href="#">USD</a>
                                <ul>
                                    <li><a href="#" class="text-primary">USD</a></li>
                                    <li><a href="#">EUR</a></li>
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
                            @else
                            <div class="rd-navbar-shop text-middle text-left">
                                <div class="rd-navbar-shop-toggle"><a href="#" data-rd-navbar-toggle=".rd-navbar-shop" class="text-middle icon icon-primary fl-line-icon-set-shopping63"></a><span class="text-middle label label-circle label-primary">1</span></div>
                                <div class="rd-navbar-shop-panel">
                                    <h4>My Cart</h4>
                                    <div class="unit unit-spacing-15 unit-horizontal rd-navbar-shop-product">
                                        <div class="unit-left"><a href="single-product.html" class="text-dark"><img alt="" src="images/header-01.jpg"></a></div>
                                        <div class="unit-body p"><a href="single-product.html" class="text-dark">Agrafe earrings</a>
                                            <p>4 x <span class="big text-regular text-primary text-spacing-40">$258.89</span></p><a href="#"><span class="rd-navbar-shop-product-delete icon mdi mdi-close"></span></a>
                                        </div>
                                    </div>
                                    <hr class="divider divider-gray divider-offset-20">
                                    <h4>Subtotal: <span class="text-regular text-primary text-normal text-spacing-40">$1,035.56</span></h4><a href="cart.html" class="btn btn-block btn-default">VIEW CART</a><a href="checkout.html" class="btn btn-block btn-primary">CHECKOUT</a>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="rd-navbar-nav-wrap">
                        <!-- RD Navbar Nav-->
                        <ul class="rd-navbar-nav">
                            @if(!Auth::check())
                            <li class="veil rd-navbar-fixed--visible"><a href="#" data-toggle="modal" data-target="#signIn">Sign In</a></li>
                            @endif
                            <li class="active"><a href="./">home</a></li>
                            @if(Auth::check())
                            <li class="veil rd-navbar-fixed--visible"><a href="/logout">Log out</a></li>
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
                <h4 class="modal-title">Sign In</h4>
            </div>
            <form id="signInForm">
                {{ csrf_field() }}
                <div class="modal-body">
                    <label class="error error-login"></label>
                    <input type="text" name="email" placeholder="Email *" class="form-control">
                    <input type="password" name="password" placeholder="Password *" class="form-control">
                    <a href="/password/reset">Forgot Your password?</a>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary offset-top-20">Sign In</button>
                    <button type="button" class="btn btn-default sign-up-button" data-dismiss="modal">Sign Up</button>
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
                <h4 class="modal-title">Sign Up</h4>
            </div>
            <form id="signUpForm">
                {{ csrf_field() }}
                <div class="modal-body">
                    <label class="error error-register"></label>
                    <input type="text" name="name" placeholder="Name *" class="form-control">
                    <input type="text" name="email" placeholder="Email *" class="form-control">
                    <input type="password" name="password" id="password" placeholder="Password *" class="form-control">
                    <input type="password" name="password_confirmation" placeholder="Password Confirm *" class="form-control">
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary offset-top-20">Sign Up</button>
                    <button type="button" class="btn btn-default sign-in-button" data-dismiss="modal">Sign In</button>
                </div>
            </form>
        </div>

    </div>
</div>
@if($errors->has('social_email_exists'))
<div id="errorModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Error</h4>
            </div>
            <div class="modal-body">
                <span class="error">{{$errors->first()}}</span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
@endif
<!-- Java script-->
<script src="/assets/js/core.min.js"></script>
<script src="/assets/js/script.js"></script>
<script type="text/javascript" src="/assets/admin/plugins/jquery-validation/js/jquery.validate.min.js"></script>
<script src="/assets/js/main.js"></script>
</body>
</html>