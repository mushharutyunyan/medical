$(document).ready(function(){
    $.ajax({
        url: '/order/getOrganizations',
        type: 'GET',
        dataType: 'json',
        success: function(data){
            var locations = data.data;
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 10,
                center: new google.maps.LatLng(data.position.latitude, data.position.longitude),
                mapTypeId: google.maps.MapTypeId.ROADMAP
            });

            var infowindow = new google.maps.InfoWindow();

            var marker, i;

            for (i = 0; i < locations.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                    map: map
                });

                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infowindow.setContent(locations[i][0]);
                        infowindow.open(map, marker);
                        $("#acceptOrganizationModal").modal('show');
                        $("#acceptOrganizationModal").find('.organization-name').html(locations[i][0])
                        $("#acceptOrganizationModal").find('.continue-button').attr('href','search/'+locations[i][3])
                    }
                })(marker, i));
            }
        }
    })
    $(".choose-organization-button").on("click",function(){
        if($('.choose-organization-list').val()){
            location.replace('/search/'+$('.choose-organization-list').val())
        }
    })
    $(".show-order-details").on("click",function(){
        $("#showOrderDetailsModal").modal('show');
    })
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
    })

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
    })
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
    })

});