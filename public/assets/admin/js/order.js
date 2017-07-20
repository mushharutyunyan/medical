$(document).ready(function(){
    $(".add-warning-drug").on("click",function(){
        if($(this).prev().val() > 0){
            $(this).closest('tr').removeClass("saved");
            $(this).closest('tr').addClass("process");
            $(this).remove();
        }
    })
    $("#order_send").validate({
        rules: {
            message: {
                required:true,
                minlength: 5,
            }
        },
        submitHandler: function(form) {
            $.ajax({
                url: "/admin/order",
                type: "POST",
                data: {data:$(form).find('textarea[name="data"]').val(),message:$(form).find('textarea[name="message"]').val(),_token:$(form).children('input[name="_token"]').val(),to:$('select[name="to"]').val(),order_send:true},
                dataType: 'json',
                success: function(data){
                    location.replace('/admin/order');
                }
            })
        }
    });
    $(".view-messages").on("click",function(e){
        e.preventDefault();
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
    })
});