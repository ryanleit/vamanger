    var latitude = "";
    var longitude = "";     
    $( document ).ready(function() {
        
        $( "#search_field" ).autocomplete({
            source: "/restaurants/auto",
                minLength: 2,
                select: function( event, ui ) {
                  //log( "Selected: " + ui.item.value + " aka " + ui.item.id );                  
                }
        });
               
        var cur_latlng = $("#latlng").val(); 
        var latlng_arr = (cur_latlng)?cur_latlng.split('_'):[];
        if(latlng_arr.length === 2){  
            latitude = latlng_arr[0];
            longitude = latlng_arr[1];
            showCurrentAddress(latitude,longitude)
        }
        //if(!$.browser.mobile){
            
        var input = document.getElementById('search_location');
        var searchBox = new google.maps.places.SearchBox(input);
        searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
              return;
            }
            //var address = place.formatted_address;
            latitude = places[0].geometry.location.lat();
            longitude = places[0].geometry.location.lng(); 
            Cookies.set("address-search",$(input).val(),{expires:1, path: '/' });
            setCookieServer(latitude,longitude);
        });
        //}
        
        $("#get_current_latlng").on('click',function(e){
            e.preventDefault();
            getNewLatlng();
        });
        $("#refresh_location").on('click',function(e){
            e.preventDefault();
            getNewLatlng();
        });  
        //displayCurrentAddress();
    });
    /*google.maps.event.addDomListener(input, 'keydown', function(e) { 
        if (e.keyCode == 13 && $('.pac-container:visible').length) { 
            e.preventDefault(); 
        }
    });*/
    function displayCurrentAddress(){
        var address_search_text = Cookies.get("address-search");
       
        if(address_search_text){
            var address_html = "<h1>Coiffeur  professionnel <small>à "+address_search_text+"</small></h1>";
            $("#current_location_text").html(address_html);
        }
        return;
    }
    function getNewLatlng(){
        var startPos;
        var geoOptions = {
            maximumAge: 5 * 60 * 1000,
            timeout: 10 * 1000,
            enableHighAccuracy: true
        };
        var geoSuccess = function(position) {
            startPos = position;                                               
            //showCurrentAddress(position.coords.latitude,position.coords.longitude);    
            Cookies.remove("address-search");            
            setCookieServer(position.coords.latitude,position.coords.longitude);
        };
        var geoError = function(error) {
          console.log('Error occurred. Error code: ' + error.code);
          // error.code can be:
          //   0: unknown error
          //   1: permission denied
          //   2: position unavailable (error response from location provider)
          //   3: timed out
        };

        navigator.geolocation.getCurrentPosition(geoSuccess, geoError, geoOptions);
    }
     //This function takes in latitude and longitude of two location and returns the distance between them as the crow flies (in km)
    function calcCrow(lat1, lon1, lat2, lon2) 
    {
      var R = 6371; // km
      var dLat = toRad(lat2-lat1);
      var dLon = toRad(lon2-lon1);
      var lat1 = toRad(lat1);
      var lat2 = toRad(lat2);

      var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
        Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2); 
      var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
      var d = R * c;
      return d;
    }

    // Converts numeric degrees to radians
    function toRad(Value) 
    {
        return Value * Math.PI / 180;
    }
    
    function setCookieServer(lat_val,lng_val){
        $.ajax({
            method: "GET",
            url: "/cookie/latlng",
            data: { lat: lat_val, lng: lng_val },
            beforeSend: function( xhr ) {
                $.loader.open();
            }
            })
            .done(function( msg ) {
                if(msg.status == 'ok'){
                    //Cookies.set("updatedLatlng",'yes',{expires:1, path: '/' });
                    var url = $("#redirect_url").val();
                    
                    if(url){
                        document.location = url;
                    }else{
                        location.reload();
                    }
                    
                    setTimeout(function() {
                       $.loader.close();
                    }, 1000);                    
                }
            });
    }
    function showCurrentAddress(lat,lng){
        //var distance = calcCrow(position.coords.latitude,position.coords.longitude,latlng_arr[0],latlng_arr[1]);
        
        var latlng = new google.maps.LatLng(lat, lng);
        var geocoder = new google.maps.Geocoder();
        //var current_address = '';
        geocoder.geocode({'latLng': latlng}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    var current_address = results[0].formatted_address;
                    var address_search_text = Cookies.get("address-search");
                    if(!address_search_text) Cookies.set("address-search",current_address,{expires:1, path: '/' });                    
                    displayCurrentAddress();
                    
                    $("#search_location").val(current_address);
                }
            } else {
                console.log("Geocoder failed due to: " + status);
            }
        });         
    }    