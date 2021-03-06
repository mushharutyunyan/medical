$(document).ready(function(){
    if($("#errorModal").length){
        $("#errorModal").modal('show');
    }
    if($("#createTicketSuccessfully").length){
        $("#createTicketSuccessfully").modal('show');
    }
    $('.sign-in-button').on("click",function(){
       $("#signIn").modal('show')
    });
    $('.sign-up-button').on("click",function(){
        $("#signUp").modal('show')
    });
    $("#signInForm").validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true
            }
        },
        submitHandler: function (form) {
            $('.error-login').html('');
            $.ajax({
                url: "/login",
                type: "POST",
                data: $(form).serialize(),
                dataType: "json",
                success: function(data){
                    location.reload();
                },
                error: function(data){
                    $('.error-login').html(JSON.parse(data.responseText).message);
                    $('.error-login').show();
                }
            })
        }
    });
    $("#signUpForm").validate({
        rules: {
            name: {
                required: true,
                minlength : 3
            },
            email: {
                required: true,
                email: true,
            },
            password : {
                required: true,
                minlength : 5
            },
            password_confirmation : {
                required: true,
                minlength : 5,
                equalTo : "#password"
            }
        },
        submitHandler: function (form) {
            $('.error-register').html('');
            $.ajax({
                url: "/register",
                type: "POST",
                data: $(form).serialize(),
                dataType: "json",
                success: function(data){
                    location.reload();
                },
                error: function(data){
                    $('.error-register').html(JSON.parse(data.responseText).email);
                    $('.error-register').html(JSON.parse(data.responseText).phone);
                    $('.error-register').show();
                }
            })
        }
    });
    $(".search").on('submit',function() {
        if ($(this).find('input[name="search"]').val() == '') {
            return false;
        }
    });
    $(".add-product").on("click",function(e){
        e.preventDefault();
        var data = {};
        var main_block = $('.shop-block');
        var products_block = main_block.find('.shop-block-products');
        var organization_id = $(this).attr('data-organization-id');
        if(products_block.attr('data-organization-id') == ''){
            products_block.attr('data-organization-id',organization_id)
        }else{
            if(products_block.attr('data-organization-id') != organization_id){
                $("#errorPorductOrganizationModal").modal("show");
                return false;
            }
        }
        var product = $(this).closest('.product');
        var product_counts = 0;
        if($('.shop-products-count').length){
            product_counts = parseInt($('.shop-products-count').html());
        }
        var image = product.find('.product-media').find('img').attr('src');
        var name = product.find('.big').text();
        var storage_id = $(this).attr('data-storage-id');
        var count = product.find('input.stepper-input').val();
        var price = parseFloat(product.find('.product-price').html()).toFixed(2);
        var _token = $(this).attr('data-token');
        data['image'] = image;
        data['name'] = name;
        data['organization_id'] = organization_id;
        data['count'] = count;
        data['price'] = price;
        data['storage_id'] = storage_id;
        data['_token'] = _token;
        $.ajax({
            url: '/order/basket/add',
            data: data,
            type: "POST",
            dataType: "json",
            success: function(data){
                if(!data){
                    $("#errorPorductExist").modal("show");
                    return false;
                }else{
                    main_block.find('.basket-subtotal').html(parseFloat(parseFloat(main_block.find('.basket-subtotal').html()) + parseFloat(price*count)).toFixed(2));
                    if(!main_block.find('.shop-products-count').length){
                        main_block.children('.shop-block-header').append('<span class="text-middle shop-products-count label label-circle label-primary"></span>')
                    }
                    ++product_counts;
                    $('.shop-products-count').html(product_counts);
                    main_block.find('.shop-block-products').append(
                        '<div class="unit unit-spacing-15 unit-horizontal rd-navbar-shop-product" data-id="'+storage_id+'">' +
                        '<div class="unit-left">' +
                        '<a href="javascript:;" class="text-dark"><img alt="" height="50" width="50" src="'+image+'"></a>' +
                        '</div>' +
                        '<div class="unit-body p"><a href="javascript:;" class="text-dark">'+name+'</a>' +
                        '<p>'+count+' x <span class="big text-regular text-primary text-spacing-40 basket-product-price">'+price+'</span></p>' +
                        '<a href="javascript:;" data-count="'+count+'" class="delete-basket-product" data-token="'+_token+'" data-id="'+storage_id+'"><span onclick="delete_basket_product(this)" class="rd-navbar-shop-product-delete icon mdi mdi-close "></span></a>' +
                        '</div>' +
                        '</div>'
                    )
                }
            }
        });
    });

    $(".stepper-arrow").on("click",function(){
        var input = $(this).parent().children('input');
        var value = parseInt($(this).parent().children('input').val());
        if($(this).hasClass('up')){
            input.val(++value)
        }else{
            if(value > 1){
                input.val(--value)
            }
        }
    })

    $(".checkout-button").on("click",function(){
       $("#checkoutModal").modal("show");
    });

    $('#radioBtn a').on('click', function(){
        var sel = $(this).data('title');
        var tog = $(this).data('toggle');
        $('#'+tog).prop('value', sel);
        $('a[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').removeClass('active').addClass('notActive');
        $('a[data-toggle="'+tog+'"][data-title="'+sel+'"]').removeClass('notActive').addClass('active');
        $('div[data-toggle="'+tog+'"]').not('[data-title="'+sel+'"]').hide();
        $('div[data-toggle="'+tog+'"][data-title="'+sel+'"]').show();
    });
    $('.pay-order').on("click",function(){
        // $("#chooseMethodPayModal").find(".modal-body").children('button').attr('data-order',$(this).attr('data-order'));
        // $("#chooseMethodPayModal").modal('show');

        $("#chooseTypePayModal").find(".modal-body").find('button').attr('data-order',$(this).attr('data-order'));
        $("#chooseTypePayModal").modal('show');
    });
    $(".choose-pay-method").on("click",function(){
        $("#chooseTypePayModal").find(".modal-body").find('button').attr('data-order',$(this).attr('data-order'));
        $("#chooseTypePayModal").modal('show');
    });
    $(".choose-pay-type").on("click",function(){
        $("#paySendModal").find('#delivery_address_form').append(
            '<input type="hidden" value="'+$(this).attr('data-order')+'" name="order">'
        );
        $("#paySendModal").find('input[name="type"]').val($(this).attr('data-id'));
        if($(this).attr('data-id') == $(this).parent().children('#delivery').val()){
            $("#paySendModal").find('.modal-title-delivery-address').show();
            $("#paySendModal").find('.modal-title-take-time').hide();
            $("#paySendModal").find('input[name="payment_type"]').val('delivery');
            $("#order_take_time").hide();
            $("#delivery_address").show();
        }else{// take from pharmacy
            $("#paySendModal").find('.modal-title-delivery-address').hide();
            $("#paySendModal").find('.modal-title-take-time').show();
            $("#paySendModal").find('input[name="payment_type"]').val('pharmacy');
            $("#order_take_time").show();
            $("#delivery_address").hide();
            $("#order_take_time").datetimepicker();
        }
        $("#paySendModal").modal('show');
    });
    $("#delivery_address_form").validate({
        rules: {
            delivery_address: {
                required: true,
                minlength: 7
            },
            take_time: {
                required: true,
            },
            unknown_user_name:{
                required: true,
                minlength: 3
            },
            unknown_user_phone:{
                required: true,
                minlength: 8,
                maxlength: 8
            }
        },
        submitHandler: function(form){
            var payment_type = $(form).find('input[name="payment_type"]').val();
            var delivery_address = '';
            var take_time = '';
            var unknown_user_name = '';
            var unknown_user_phone = '';
            if(payment_type == 'delivery'){
                delivery_address = $(form).find('input[name="delivery_address"]').val();
                take_time = '';
            }else if(payment_type == 'pharmacy'){
                delivery_address = '';
                take_time = $(form).find('input[name="order_take_time"]').val();
            }else{
                return false;
            }
            if($(form).find('input[name="unknown_user_name"]').length){
                unknown_user_name = $(form).find('input[name="unknown_user_name"]').val();
            }
            if($(form).find('input[name="unknown_user_phone"]').length){
                unknown_user_phone = $(form).find('input[name="unknown_user_phone"]').val();
            }
            send_order(
                $(form).find('input[name="payment_method"]').val(),
                $(form).find('input[name="type"]').val(),
                $(form).find('input[name="order"]').val(),
                delivery_address,
                take_time,
                unknown_user_name,
                unknown_user_phone,
                $(form).find('input[name="_token"]').val()
            )
        }
    })

    $(".get-drug-info").on("click",function(){
       var id = $(this).attr('data-id');
       $.ajax({
           url: '/order/info',
           type: 'GET',
           data: {id:id},
           dataType: 'json',
           success: function(data){
                $(".drug-info-modal-table tbody").html('');
                $.each(data,function(key,value){
                    $(".drug-info-modal-table tbody").append(
                        '<tr style="text-align: left">' +
                        '<td>'+value.name+'</td>' +
                        '<td>'+value.value+'</td>' +
                        '</tr>'
                    )
                })
               $("#drugInfoModal").modal('show');
           }
       })
    });
    if($("#orderFinishModal").length){
        $("#orderFinishModal").modal('show');
    }
    $(".search-button").on("click",function(){
        $(".search-form").submit();
    })


    // RANK STARS ORDER
    if($(".rateYo").length){
        $(".rateYo").each(function(){
            var rate = 0;
            if($(this).attr('data-rate') != ''){
                rate = $(this).attr('data-rate');
            }
            $(this).rateYo({
                rating: rate,
                onSet: function (rating, rateYoInstance) {
                    if($(this).attr('data-rate') == ''){
                        $(this).next().val(rating);
                        $(this).off('click');
                        $.ajax({
                            url: '/order/rank/stars',
                            type: 'GET',
                            data: {rating:rating,id:$(this).attr('data-id')},
                            dataType: 'json',
                            success: function(data){
                                $("#thankYouForRatingModal").modal('show')
                            }
                        })
                    }else{
                        $(this).off('click');
                    }
                },
            });
            if($(this).attr('data-rate') != ''){
                $(this).off('click');
            }
        });
    }
});
function send_order(method,type,order,address,take_time,unknown_user_name, unknown_user_phone,_token){
    console.log(_token)
    $.ajax({
        url: '/order/pay',
        type: 'POST',
        data: {method:method,type:type,order:order,address:address,take_time:take_time,unknown_user_name:unknown_user_name,unknown_user_phone:unknown_user_phone,_token:_token},
        dataType: 'json',
        success: function(data){
            $("#paySendModal").modal('hide');
            $("#orderPayFinishModal").modal('show');
            $('.pay-order').remove();
        }
    })
}

function delete_basket_product(self){
    var storage_id = $(self).parent().attr('data-id');
    var cart_row = false;
    if($(self).parent().hasClass('cart-row')){
        cart_row = true;
        $('.shop-block-products .unit').each(function(key,value){
            if($(this).attr('data-id') == storage_id){
                $(self).closest('tr').remove();
                self = $(this).find('.delete-basket-product span');
            }
        })
    }
    var main_block = $('.shop-block');
    var current_block = $(self).closest('.unit');
    var current_price = parseFloat(current_block.find('.basket-product-price').html()).toFixed(2);
    var price = parseFloat(main_block.find('.basket-subtotal').html()).toFixed(2);
    var count = parseInt($('.shop-products-count').html());
    var current_count = $(self).parent().attr('data-count')
    var _token = $(self).parent().attr('data-token');
    --count;
    if(!count){
        $('.shop-products-count').remove()
    }else{
        $('.shop-products-count').html(count)
    }
    var new_price = parseFloat(price - current_price*current_count).toFixed(2);
    main_block.find('.basket-subtotal').html(new_price);
    if(cart_row){
        $(".cart_totals-price").html(new_price);
    }
    current_block.remove();

    $.ajax({
        url: '/order/basket/delete',
        data: {storage_id:storage_id,_token:_token},
        type: "POST",
        dataType: "json",
        success: function(data){

        }
    })


}
