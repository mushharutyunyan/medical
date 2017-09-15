$(document).ready(function(){
    $(".add-warning-drug").on("click",function(){
        if($(this).prev().val() > 0){
            $(this).closest('tr').removeClass("saved");
            $(this).closest('tr').addClass("process");
            $(this).remove();
        }
    });
    $(document).on("change",'.order-deliver-statuses',function(){
        var val = $(this).val();
        if(val == 2){//delivery
            $(this).parent().append('<input type="text" name="order_delivery_address" id="order_delivery_address" placeholder="Order delivery address" class="form-control">')
        }else{
            $("#order_delivery_address").remove();
            $("#order_delivery_address-error").remove();
        }
    });
    $(document).on("change",'.order-send-statuses',function(){
        var val = $(this).val();
        if(val == 3){//approved
            $('.order-send-statuses').parent().append('<input class="form-control datepicker" id="order_delivery_date" name="delivery_date" placeholder="Auto 3 hours later" data-date-format="yyyy-mm-dd">')
            $('.datepicker').datepicker();
        }else{
            $("#order_delivery_date").remove();
        }
    });
    $("#order_send").validate({
        rules: {
            message: {
                required:true,
                minlength: 5,
            },
            order_delivery_address: {
                required:true,
                minlength: 5,
            }
        },
        submitHandler: function(form) {
            var url = '/admin/order';
            var method = 'POST';
            var status = 1,
                delivery_status_id = 0,
                order_delivery_address = 0,
                delivery_date;
            if($(form).hasClass('edit')){
                url = '/admin/order/'+$(form).attr('data-id');
                method = 'PUT';
            }
            $(".send-order-message-button").attr("disabled","disabled");
            if($(form).find('select[name="status"]').length){
                status = $(form).find('select[name="status"]').val();
            }
            if($(form).find('select[name="delivery_status_id"]').length){
                delivery_status_id = $(form).find('select[name="delivery_status_id"]').val();
            }
            if($(form).find('input[name="order_delivery_address"]').length){
                order_delivery_address = $(form).find('input[name="order_delivery_address"]').val();
            }
            if($(form).find('input[name="delivery_date"]').length){
                delivery_date = $(form).find('input[name="delivery_date"]').val();
            }
            $data = {};
            $data['data'] = $(form).find('textarea[name="data"]').val();
            $data['message'] = $(form).find('textarea[name="message"]').val();
            $data['_token'] = $(form).children('input[name="_token"]').val();
            $data['to'] = $('select[name="to"]').val();
            $data['order_send'] = true;
            $data['status'] = status;
            $data['delivery_status_id'] = delivery_status_id;
            $data['order_delivery_address'] = order_delivery_address;
            $data['delivery_date'] = delivery_date;
            $.ajax({
                url: url,
                type: method,
                data: $data,
                dataType: 'json',
                success: function(data){
                    location.replace('/admin/order');
                }
            })
        }
    });
    $(".view-messages").on("click",function(e){
        e.preventDefault();
        $(this).html('<i class="fa fa-envelope"></i>');
        $("#view_order_message").find(".chats").html('');
        $.ajax({
            url:'/admin/order/messages/'+$(this).attr('data-id'),
            type: "GET",
            dataType: 'json',
            success: function(data){
                $.each(data,function(key,value){
                    $("#view_order_message").find(".chats").append('<li class="in"><img class="avatar" alt="" src="/assets/admin/img/avatar.png"/><div class="message"><span class="arrow"></span><a href="#" class="name"></a><span class="datetime">'+value.created_at+' </span><span class="body">'+value.message+'</span></div></li>');
                })
            }
        })
        $("#view_order_message").modal('show');
    });
    $(document).on("change","#order_table_status",function(){
        if($(this).val() != 0){
            $("#change_order_status_to_modal").modal('show');
            $("#change_order_status_to").find("#status").val($(this).val())
            $("#change_order_status_to").find("#order_id").val($(this).parent().children('input[name="id"]').val());
            if($(this).val() == 3){//approved
                $('.change-order-status-to-message').parent().prepend('<input class="form-control datepicker" id="order_delivery_date" name="delivery_date" placeholder="Auto 3 hours later" data-date-format="yyyy-mm-dd">')
                $('.datepicker').datepicker();
            }
            $("#change_order_status_to").validate({
                rules: {
                    message: {
                        required:true,
                        minlength: 5,
                    }
                },
                submitHandler: function(form) {
                    $("#change_order_status_to").find('span.error').html('');
                    $.ajax({
                        url: "/admin/order/changeStatusTo",
                        data: $(form).serialize(),
                        type: "POST",
                        dataType: "json",
                        success: function(data){
                            if(data.error){
                                $("#change_order_status_to").find('span.error').html(data.error)
                            }else{
                                location.replace('/admin/order')
                            }
                        }
                    })
                }
            })
            // $.confirm({
            //     animation: 'bottom',
            //     closeAnimation: 'bottom',
            //     title: 'Confirm!',
            //     content: 'Are you sure?',
            //     buttons: {
            //         confirm: function () {
            //             $("#form_change_order_status").submit();
            //         },
            //         cancel: function () {
            //
            //         }
            //     }
            // });
        }
    })

    $(document).on("click",".send-saved-order-button",function(){
        $("#change_order_status").find("#order_id").val($(this).attr("data-id"));
        $("#change_order_status").find("#status").val($(this).attr("data-status"));
        $("#change_order_status_modal").modal("show");
        $("#change_order_status").validate({
            rules: {
                message: {
                    required: true,
                    minlength: 5,
                }
            },
            submitHandler: function (form) {

                $.ajax({
                    url: "/admin/order/changeStatus",
                    data: $(form).serialize(),
                    type: "POST",
                    dataType: "json",
                    success: function(data){
                        location.replace('/admin/order/')
                    }
                })
            }
        });
    })
    $(document).on("click",".view-files",function(e){
        e.preventDefault();
        $(".order-files-block").html("");
        $.ajax({
            url: "/admin/order/excel/get",
            data: {order_id:$(this).attr('data-id')},
            type: "GET",
            dataType: "json",
            success: function(data){
                $(".order-files-block").html('<ul class="list-group order-files-list"></ul>');
                var i = 0;
                $.each(data.files,function(key,value){
                    if(value){
                        if(i == 0){
                            if(data.approved){
                                $('.order-files-list').append('<li class="list-group-item" style="background-color: greenyellow"><a target="_blank" href="/admin/order/excel/download/'+value.file+'"><i class="fa fa-file-excel-o" aria-hidden="true"></i>'+value.created_at+' (Approved file)</a></li>')
                            }else{
                                $('.order-files-list').append('<li class="list-group-item"><a target="_blank" href="/admin/order/excel/download/'+value.file+'"><i class="fa fa-file-excel-o" aria-hidden="true"></i>'+value.created_at+'</a></li>')
                            }
                        }else{
                            $('.order-files-list').append('<li class="list-group-item"><a target="_blank" href="/admin/order/excel/download/'+value.file+'"><i class="fa fa-file-excel-o" aria-hidden="true"></i>'+value.created_at+'</a></li>')
                        }
                        i++;
                    }
                })
                $("#view_order_files").modal('show');
            }
        })
    })
    $("#order_organization_list").on('change',function(){
        $(".change_organization_form").submit();
    })
    $(".received-order").on("click",function(e){
        e.preventDefault();
        var order_id = $(this).parent().children('input[name="order_id"]').val();
        var _token = $(this).parent().children('input[name="_token"]').val();
        $.ajax({
            url: '/admin/order/getReceivedInfo',
            type: 'POST',
            data: {order_id:order_id,_token:_token},
            dataType: 'json',
            success: function(data){
                $("#received_modal").find('.order-files-block tbody').html("");
                $.each(data,function(key,value){
                    var settings = '';
                    $.each(value.settings,function(key_settings,value_settings){
                        $.each(value_settings,function(setting_name,setting_value){
                            settings += "<p>"+setting_name+": "+setting_value+"</p>";
                        })
                    });
                    $("#received_modal").find('.order-files-block tbody').append(
                        '<tr>' +
                        '<td>'+value.name+'</td>' +
                        '<td>'+value.count+'</td>' +
                        '<td>'+settings+'</td>' +
                        '<td><input name="price" data-id="'+value.id+'" value="'+value.price+'" class="form-control"></td>' +
                        '<td><input name="procent" class="form-control">%</td>' +
                        '</tr>'
                    )
                })
                $("#received_modal").modal('show');
                $(".received-order-modal").attr('data-id',order_id);
            }
        })
    })
    $(".received-order-modal").on("click",function(){
        // changeStatus/received
        $data = {};
        var access = true;
        $("#received_modal").find('.order-files-block tbody tr').each(function(){
            var price = $(this).find('input[name="price"]').val();
            var procent = $(this).find('input[name="procent"]').val();
            var order_info_id = $(this).find('input[name="price"]').attr('data-id');
            if(price < 0 || price == ''){
                $.alert({
                    title: 'Warning!',
                    content: 'Check Drug prices!',
                });
                access = false;
            }
            if(procent > 0){
                price = ((parseFloat(procent*price/100)) + parseFloat(price)).toFixed(2);
                $(this).find('input[name="price"]').val(price);
            }
            $data[order_info_id] = price;
        });

        if(access){
            $data['order_id'] = $(this).attr('data-id');
            $data['_token'] = $(this).parent().children('input[name="_token"]').val();
            $(this).html('Waiting ...')
            $(this).attr('disabled','disabled')
            $.ajax({
                url: '/admin/order/changeStatus/received',
                data: $data,
                type: "POST",
                dataType: 'json',
                success: function(data){
                    location.replace('/admin/order');
                }
            })
        }
    })
});