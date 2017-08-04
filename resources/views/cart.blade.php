@extends('layouts.main')
@section('title', config('app.name')." | ".Lang::get('main.mycart'))
@section('content')
    <div class="shell">
        <div>
            <ol class="breadcrumb">
                <li><a href="./" class="icon icon-sm fa-home text-primary"></a></li>
                <li class="active">{{Lang::get('main.mycart')}}
                </li>
            </ol>
        </div>
    </div>
    <div class="shell section-bottom-60 offset-top-4">
        <form action="/order/basket/update" method="POST" class="shoping-cart">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th></th>
                        <th colspan="2">Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $all_prices = 0;
                    $i = 0;
                    ?>
                    @if(session('order'))
                    @foreach(session('order') as $order)
                    <?php
                    $all_prices += $order['price']*$order['count'];
                    ?>
                    <tr class="cart_item">
                        <input type="hidden" name="name_{{$i}}" value="{{$order['name']}}">
                        <input type="hidden" name="image_{{$i}}" value="{{$order['image']}}">
                        <input type="hidden" name="price_{{$i}}" value="{{$order['price']}}">
                        <input type="hidden" name="storage_id_{{$i}}" value="{{$order['storage_id']}}">
                        <td class="product-remove cart-row" data-count="{{$order['count']}}" data-token="{{csrf_token()}}" data-id="{{$order['storage_id']}}"><a href="#" class=" icon icon-xs text-primary mdi mdi-close" onclick="delete_basket_product(this)"></a></td>
                        <td class="product-thumbnail"><a href="javascript:;" class="reveal-inline-block"><img src="{{$order['image']}}" width="100" height="100" alt=""></a></td>
                        <td class="product-name">
                            <p><a href="single-product.html" class="text-base">{{$order['name']}}</a></p>
                        </td>
                        <td class="product-price">
                            <p class="big text-primary">{{$order['price']}}</p>
                        </td>
                        <td class="product-quantity">
                            <input name="count_{{$i}}" value="{{$order['count']}}" class="form-control">
                        </td>
                        <td class="product-subtotal">
                            <p class="big text-primary">{{$order['price'] * $order['count']}}</p>
                        </td>
                    </tr>
                    <?php
                    $i++;
                    ?>
                    @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <div class="clearfix offset-top-30">
                {{--<div class="pull-sm-left offset-top-30 offset-sm-top-0">--}}
                    {{--<div class="form-inline-flex reveal-xs-flex">--}}
                        {{--<div class="form-group offset-bottom-0">--}}
                            {{--<input type="text" name="coupon" placeholder="Enter Code" class="form-control">--}}
                        {{--</div>--}}
                        {{--<button type="submit" class="btn btn-default offset-xs-left-10 offset-top-10 offset-xs-top-0">Aplly coupon</button>--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="pull-sm-right offset-top-20 offset-sm-top-0"><button class="btn btn-default">Update card</button></div>
            </div>
            <hr class="offset-top-30 divider divider-gray">
            <div class="clearfix offset-top-30">
                <div class="cart_totals pull-sm-right">
                    <h4 class="text-left text-thin">Cart Totals</h4>
                    <div class="range-middle reveal-flex range-justify offset-top-20">
                        <p class="text-spacing-40 text-thin offset-bottom-0">Subtotal:</p>
                        <p class="text-regular cart_totals-price">{{$all_prices}}</p>
                    </div>
                    <div class="range-middle reveal-flex range-justify offset-top-10">
                        <p class="text-spacing-40 text-thin offset-bottom-0">total:</p>
                        <p class="text-regular cart_totals-price">{{$all_prices}}</p>
                    </div><a href="checkout.html" class="offset-top-20 btn btn-primary">Proceed to Checkout</a>
                </div>
            </div>
        </form>
    </div>
@endsection