$(document).ready(function(){
    $(".show-order-details-history").on("click",function(){
        $.ajax({
            url: '/order/details',
            data: {_token:$(this).attr('data-token'),id:$(this).attr('data-id')},
            type: 'POST',
            dataType: 'json',
            success: function(data){
                if(!data.error){
                    $('.order-details-modal-table tbody').html('');
                    $.each(data.details,function(key,value){
                        $('.order-details-modal-table tbody').append(
                            '<tr style="text-align: left">' +
                            '<td>'+value.trade_name+'</td>' +
                            '<td>'+value.count+'</td>' +
                            '<td>'+(value.price*value.count)+'</td>' +
                            '</tr>'
                        )
                    });
                    $("#showOrderDetailsModal").modal("show");
                }
            }
        })
    });
    $(".add-order-message").on('submit',function(e){
        e.preventDefault();
        var self = this;
        var message = $(this).find("#message").val();
        if(message == ''){
            return false;
        }
        $.ajax({
            url:$(this).attr('action'),
            type: $(this).attr('method'),
            data: $(this).serialize(),
            dataType: 'json',
            success: function(data){
                if(data){
                    $(".chat").append(
                        '<div class="message">' +
                        '<span>'+data.from+': ('+data.date+')</span>' +
                        '<p>'+data.message+'</p>' +
                        '</div>'
                    )
                    $(self).find("#message").val('');
                }
            }
        })
    });
    $(".show-order-details-messages").on("click",function(){
        $.ajax({
            url: '/order/getMessages',
            data: {_token:$(this).attr('data-token'),id:$(this).attr('data-id')},
            type: 'POST',
            dataType: 'json',
            success: function(data){
                if(!data.error){
                    $("#showOrderMessagesModal").find('.chat').html('');
                    $.each(data.messages,function(key,value){
                        $("#showOrderMessagesModal").find('.chat').append(
                            '<div class="message">' +
                            '<span>'+value.from+': ('+value.date+')</span>' +
                            '<p>'+value.message+'</p>' +
                            '</div>'
                        );
                    });
                    $("#showOrderMessagesModal").find('.add-order-message').find('input[name="order"]').val(data.order.order);
                    $("#showOrderMessagesModal").find('.add-order-message').find('input[name="id"]').val(data.order.id);
                    $("#showOrderMessagesModal").modal("show");
                }
            }
        })
    });

    $(".delete-order-detail").on("click",function(){
        var self = this;
        $.confirm({
            animation: 'bottom',
            closeAnimation: 'bottom',
            title: 'Confirm!',
            content: 'Are You sure?',
            buttons: {
                confirm: function () {

                    $.ajax({
                        url: '/admin/userOrder/details/delete',
                        type: 'GET',
                        data: {'id':$(self).attr('data-id')},
                        dataType: 'json',
                        success: function(){
                            $(self).closest('tr').remove();
                        }
                    })
                },
                cancel: function () {

                }
            }
        });
    })

    $(".changeOrderDetails").on("submit",function(e){
        e.preventDefault();
        var data = {}
        var i = 0
        $(this).find('table tbody tr').each(function(key,value){
            data[i] = {id:$(this).children('input[name="id"]').val(),count:$(this).find('input[name="count"]').val(),price:$(this).find('input[name="price"]').val()};
            i++;
        });
        console.log(data);
        $("#sendUserOrderMessageModal").modal('show');
        $("#sendUserOrderMessageModal").find('input[name="details"]').val(JSON.stringify(data));

    });

    $('.saveOrderDetails').on('submit',function(e){
        e.preventDefault();
        var self = this;
        $.confirm({
            animation: 'bottom',
            closeAnimation: 'bottom',
            title: 'Confirm!',
            content: 'Are You sure?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: $(self).attr('action'),
                        type: $(self).attr('method'),
                        data: $(self).serialize(),
                        dataType: 'json',
                        success: function(){
                            location.replace('/admin/userOrder');
                        }
                    })
                },
                cancel: function () {

                }
            }
        });
    })

    $(".cancel-order, .approved-order").on("click",function(e){
        e.preventDefault();
        var self = this;
        $.confirm({
            animation: 'bottom',
            closeAnimation: 'bottom',
            title: 'Confirm!',
            content: 'Are You sure?',
            buttons: {
                confirm: function () {
                    location.replace($(self).attr('href'));
                },
                cancel: function () {

                }
            }
        });
    });

    $(".finish-order").on("click",function(e){
        e.preventDefault();
        $.ajax({
            url: '/admin/userOrder/details/finishOrder',
            type: 'GET',
            data: {id:$(this).attr('data-id')},
            dataType: 'json',
            success: function(data){
                $("#delivery_time").remove();
                $("#order_finish_form input").show();
                $("#order_finish_form select option").each(function(key,value){
                    if($(this).val() == data.pay_type_id){
                        $("select[name='pay_type']").val($(this).val())
                    }
                })
                $("#order_finish_form input").each(function(key,value){
                    if($(this).attr('name') != data.pay_type){
                        $(this).hide();
                    }else{
                        $(this).val(data.take_time_delivery)
                        if(data.delivery){
                            $(this).parent().append('<input type="text" class="form-control" name="delivery_time" id="delivery_time" placeholder="delivery time">');
                            $("#delivery_time").datetimepicker();
                        }
                    }
                });
                $("#order_finish_form input[name='order_id']").val(data.id)
                $("#order_finish_form input[name='take_time']").datetimepicker();
                $("#userOrderFinish").modal('show');
            }
        })
    })
    $("#order_finish_form").validate({
        rules:{
            take_time: {
                required: true,
            },
            delivery_time: {
                required: true,
            }
        },
        submitHandler: function (form) {
            $.ajax({
                url: '/admin/userOrder/finish/pharmacy',
                type: 'POST',
                data: $(form).serialize(),
                dataType: 'json',
                success: function(){
                    location.reload();
                }
            })
        }
    })
    $(".finished_delivery").on("click",function(){
        $.ajax({
            url: '/admin/userOrder/'+$(this).attr('data-id')+'/finish/delivery',
            type: 'GET',
            dataType: 'json',
            success: function(){
                location.reload();
            }

        })
    })

    $(".user_order_datatable").dataTable();
});