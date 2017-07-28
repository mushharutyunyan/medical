$(document).ready(function(){
    $('.current-chat').on('click',function(){
        var partner_id = $(this).attr('data-id');
        var tab_id = $(this).attr('data-child-tab');
        $('#'+tab_id).find('.chats').html('');
        $('#'+tab_id).find('.loading').show();
        $.ajax({
            url: '/admin/message/'+partner_id,
            type: 'GET',
            dataType: 'json',
            success: function(data){
                $.each(data,function(key,value){
                    var row_class = 'out';
                    if(value.from == partner_id){
                        var row_class = 'in';
                    }
                    $('#'+tab_id).find('.chats').append(
                        '<li class="'+row_class+'">' +
                            '<div class="message">' +
                                '<span class="arrow"></span>' +
                                '<a href="#" class="name"></a>' +
                                '<span class="datetime">'+value.created_at+'</span>' +
                                '<span class="body">'+value.message+'</span>' +
                            '</div>' +
                        '</li>'
                    )
                })
                $('#'+tab_id).find('.loading').hide();
            }
        })
    });
    $('.add-chat-message').on('submit',function(e){
        e.preventDefault();
        var self = this;
        var message = $(this).find('input[name="message"]').val();
        if(message != ''){
            var data = {};
            var tab_id = $(this).attr('data-tab');
            var token = $(this).children('input[name="_token"]').val();
            var partner_id = $(this).find('input[name="partner_id"]').val();
            data['_token'] = token;
            data['to'] = partner_id;
            data['message'] = message;
            $(self).find('button').attr('disabled','disabled');
            $.ajax({
                url: '/admin/message',
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function(data){
                    $('#'+tab_id).find('.chats').append(
                        '<li class="out">' +
                            '<div class="message">' +
                            '<span class="arrow"></span>' +
                            '<a href="#" class="name"></a>' +
                            '<span class="datetime">Now</span>' +
                            '<span class="body">'+message+'</span>' +
                            '</div>' +
                        '</li>'
                    )
                    $(self).find('input[name="message"]').val('');
                    $(self).find('button').removeAttr('disabled');
                }
            });
        }
    })
});