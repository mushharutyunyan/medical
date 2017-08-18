$(document).ready(function(){
    // In the following example, markers appear when the user clicks on the map.
    // The markers are stored in an array.
    // The user can then click an option to hide, show or delete the markers.
    var map;
    var markers = [];
    initMap();
    function initMap() {
        var lat = $('input[name="latitude"]').val();
        var lng = $('input[name="longitude"]').val();
        if(lat == ''){
            lat =  40.18436521290417
            lng =  44.517728090286255
        }
        // $('input[name="latitude"]').val('');
        // $('input[name="longitude"]').val('');
        var haightAshbury = {lat: parseFloat(lat), lng: parseFloat(lng)};

        map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: haightAshbury,
            mapTypeId: 'terrain'
        });

        // This event listener will call addMarker() when the map is clicked.
        map.addListener('click', function(event) {
            addMarker(event.latLng);
        });

        if($("#map").attr('data-type') != 'create'){
            // Adds a marker at the center of the map.
            addMarker(haightAshbury);
        }
    }

    // Adds a marker to the map and push to the array.
    function addMarker(location) {
        var marker = new google.maps.Marker({
            position: location,
            map: map
        });
        deleteMarkers();
        if($.isFunction(location.lat)){
            $('input[name="latitude"]').val(location.lat());
            $('input[name="longitude"]').val(location.lng());
        }
        markers.push(marker);
    }

    // Sets the map on all markers in the array.
    function setMapOnAll(map) {
        for (var i = 0; i < markers.length; i++) {

            markers[i].setMap(map);
        }
    }

    // Removes the markers from the map, but keeps them in the array.
    function clearMarkers() {
        setMapOnAll(null);
    }

    // Shows any markers currently in the array.
    function showMarkers() {
        setMapOnAll(map);
    }

    // Deletes all markers in the array by removing references to them.
    function deleteMarkers() {
        clearMarkers();
        markers = [];
    }
});