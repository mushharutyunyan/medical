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

            // Create the search box and link it to the UI element.
            var input = document.getElementById('address');
            var searchBox = new google.maps.places.SearchBox(input);
            map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

            // Bias the SearchBox results towards current map's viewport.
            map.addListener('bounds_changed', function() {
                searchBox.setBounds(map.getBounds());
            });

            var markers = [];
            // Listen for the event fired when the user selects a prediction and retrieve
            // more details for that place.
            searchBox.addListener('places_changed', function() {
                var places = searchBox.getPlaces();

                if (places.length == 0) {
                    return;
                }

                // Clear out the old markers.
                markers.forEach(function(marker) {
                    marker.setMap(null);
                });
                markers = [];

                // For each place, get the icon, name and location.
                var bounds = new google.maps.LatLngBounds();
                places.forEach(function(place) {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }
                    var icon = {
                        url: place.icon,
                        size: new google.maps.Size(71, 71),
                        origin: new google.maps.Point(0, 0),
                        anchor: new google.maps.Point(17, 34),
                        scaledSize: new google.maps.Size(25, 25)
                    };

                    // Create a marker for each place.
                    markers.push(new google.maps.Marker({
                        map: map,
                        icon: icon,
                        title: place.name,
                        position: place.geometry.location
                    }));

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
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
                        infowindow.setContent(locations[i][0]+'<br>'+locations[i][4]+'<br>'+locations[i][5]);
                        infowindow.open(map, marker);
                        $("#acceptOrganizationModal").modal('show');
                        $("#acceptOrganizationModal").find('.organization-name').html(locations[i][0]+'<br>'+locations[i][4]+'<br>'+locations[i][5])
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

    })
    $(".show-order-details-messages").on("click",function(){

    })
    $(".canceled_closed_by_user").on("click",function(e){
        e.preventDefault();
        $("#confirmationModal").modal('show');
        var data = '';
        if($(this).hasClass('canceled')){
            data = 'status=canceled';
        }else{
            data = 'status=closed';
        }
        data += '&_token='+$(this).closest('form').children('input[name="_token"]').val()+'&id='+$(this).closest('form').children('input[name="id"]').val();
        $("#confirmationModal .accept-confirm").attr('data-serialize',data);
    })
    $(".accept-confirm").on('click',function(){
        $.ajax({
            url: '/order/canceled',
            data: $(this).attr('data-serialize'),
            type: "POST",
            dataType: 'json',
            success: function(){
                location.reload();
            }
        })
    })
});
function show_order_details_history(self){
    $.ajax({
        url: '/order/details',
        data: {_token:$(self).attr('data-token'),id:$(self).attr('data-id')},
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
                        '<td>'+(value.price)+'</td>' +
                        '<td>'+(value.price*value.count)+'</td>' +
                        '</tr>'
                    )
                });
                $("#showOrderDetailsModal").modal("show");
            }
        }
    })
}
function show_order_details_messages(self){
    $.ajax({
        url: '/order/getMessages',
        data: {_token:$(self).attr('data-token'),id:$(self).attr('data-id')},
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
}