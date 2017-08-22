$(document).ready(function(){
    $(document).keypress(function(e) {
        if(e.which == 13) {
            return false;
        }
    });
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
            zoom: 18,
            center: haightAshbury,
            mapTypeId: 'terrain'
        });

        // Create the search box and link it to the UI element.
        var input = document.getElementById('pac-input');
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
