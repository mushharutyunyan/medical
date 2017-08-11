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
                            '<td>'+value.price+'</td>' +
                            '</tr>'
                        )
                    });
                    $("#showOrderDetailsModal").modal("show");
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
});