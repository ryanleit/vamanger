    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">
    var lat = -33.8688;
    var lng = 151.2195;
    function initMap() {
        //var pos = {lat: -33.8688,lng: 151.2195};
        // Try HTML5 geolocation.                
        if($("#lat").val() !== "" && $("#lng").val() !== ""){
            lat = Number($("#lat").val());
            lng = Number($("#lng").val());            
        }     
        var map = new google.maps.Map(document.getElementById('map'));
        map.setCenter({lat: lat, lng: lng});
        map.setZoom(17);  // Why 17? Because it looks good.
        
        var card = document.getElementById('pac-card');
        var input = document.getElementById('pac-input');
        
        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

        var autocomplete = new google.maps.places.Autocomplete(input);

        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo('bounds', map);

        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
          map: map,
         // anchorPoint: new google.maps.Point(0, -29),
          position: {lat: lat, lng: lat},
        });        
        
        autocomplete.addListener('place_changed', function() {
            infowindow.close();
            marker.setVisible(false);
            var place = autocomplete.getPlace();
            if (!place.geometry) {
              // User entered the name of a Place that was not suggested and
              // pressed the Enter key, or the Place Details request failed.
              window.alert("No details available for input: '" + place.name + "'");
              return;
            }
            //var address = place.formatted_address;
             var latitude = place.geometry.location.lat();
             var longitude = place.geometry.location.lng();
             $("#lat").val(latitude);
             $("#lng").val(longitude);
              // If the place has a geometry, then present it on a map.
              if (place.geometry.viewport) {                 
                map.fitBounds(place.geometry.viewport);
              } else {               
                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
              }
              marker.setPosition(place.geometry.location);
              marker.setVisible(true);

              var address = '';
              if (place.address_components) {
                address = [
                  (place.address_components[0] && place.address_components[0].short_name || ''),
                  (place.address_components[1] && place.address_components[1].short_name || ''),
                  (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
              }

              infowindowContent.children['place-icon'].src = place.icon;
              infowindowContent.children['place-name'].textContent = place.name;
              infowindowContent.children['place-address'].textContent = address;
              infowindow.open(map, marker);
        });
      
        return map;
    }
    // A $( document ).ready() block.
    
    $( document ).ready(function() { 
        
            /*if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    if($("#lat").val() === "" && $("#lng").val() === ""){
                        $("#lat").val(position.coords.latitude);
                        $("#lng").val(position.coords.longitude);            
                    }            
                    
                }, function() {
                    console.log("Geo location failed.");
                });
            }else{
                console.log("Not allow.");
            }*/
        
        var map = initMap();
        
        $("#myModal").on("shown.bs.modal", function () {
            google.maps.event.trigger(map, "resize");
            //map.setCenter(latlng);
        });
    });
    
    