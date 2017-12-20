@extends('layouts.app_homepage')

@section('content')
<div class="container">
    <div class="row">              
        <div class="col-md-12">            
            <div class="row">
                <!--/stories-->
                <div class="panel  panel-info">                               
                    <div class="panel-body" style="min-height: 700px;"> 
                        <div class="col-md-12 margin-bottom" style="margin-top: 50px;">   
                            @if(Session::has('fail_message'))
                            <div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                {{ Session::get('fail_message') }}
                            </div>
                            @endif
                            @if(Session::has('success_message'))
                            <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                {{ Session::get('success_message') }}
                            </div>
                            @endif
                            <div class="text-center"><h2><strong><span class="text-primary">{{__('homepage.choose_resto')}}</span></strong></h2></div>
                            <div class="col-md-9 col-md-offset-3 margin-bottom">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <div class="icon-addon addon-lg">
                                            <input type="text" class="form-control" id="search_location" name="search_location" placeholder="Enter location">                                                                      
                                            <label for="search_location" class="glyphicon glyphicon-search" rel="tooltip" title="Search"></label>
                                        </div>
                                        <input type="hidden" id="latlng" name="latlng" value="{{request()->cookie('latlng')}}" >
                                        <input type="hidden" name="redirect_url" id="redirect_url" value="/">
                                    </div>                                                                    
                                </div>
                                                            
                            </div>                            
                        </div>
                        
                        <!--/stories-->                     
                        <div class="col-md-8 col-md-offset-2" style="margin-top: 30px;">                             
                            <div class="col-md-10 col-md-offset-1 margin-bottom">
                                <a href="{{route('dish_quick_add')}}" class="btn btn-block btn-primary">{{ __('menus.restaurant_notin_list') }}</a>
                            </div>
                            <div id="restaurant_list" style="margin-top: 50px;">
                            @foreach($restaurants as $restaurant)
                            <div class="col-md-10 col-md-offset-1 margin-bottom">                         
                                <div class="col-md-10  panel panel-primary">
                                    <div class="row">
                                        <div class="col-md-9">
                                        <span class="text-bold"> <strong>{{$restaurant['name']}}</strong> </span>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="pull-right">
                                                @if ($restaurant['distance'] >= 0)
                                                    @if ($restaurant['distance'] >= 1)
                                                    {{round($restaurant['distance'],2)}}{{' km'}}
                                                    @else
                                                    {{round(($restaurant['distance'] * 1000),0)}}{{' m'}}
                                                    @endif
                                                @endif
                                            </span>                                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-9"
                                        <span>{{$restaurant['address']}} </span>
                                        </div>
                                        <div class="col-md-3">
                                            <span class="badge pull-right" style="background: violet">{{$restaurant['menus_count']}}</span>
                                        </div>
                                    </div>                            
                                </div>                            
                                <div class="col-md-2">
                                    <a href="{{route('dish_quick_add',['restaurant_id'=>(!empty($restaurant['id']))?$restaurant['id']:$restaurant['place_id']])}}" class="link">
                                        <span class="btn btn-danger">
                                             <i class="fa fa-plus"></i> {{ __('menus.flat_addition')}}
                                        </span>
                                    </a>
                                </div>
                            </div>
                            @endforeach
                            </div>
                            <div class="col-md-8 col-md-offset-2">
                                @if(!empty($next_page))
                                <div class="text-center" id="more_result_div">
                                    <a href="javascript:void(0);" class="btn btn-success" id="more_result">{{ __('menus.view_more_restaurant') }}</a>
                                    <input type="hidden" id="page_token" name="page_token" value="{{$next_page}}" />
                                </div>
                                @endif
                            </div>                        
                        </div> 
                        
                    </div>
                </div>                                                                       
            </div>                       
        </div>
    </div>
</div>
@endsection
@section('footer_js')
<script type="text/javascript">
    $( document ).ready(function() {       
        var cur_latlng = Cookies.get("latlng");  
        
        if(!cur_latlng){  
            getNewLatlng();
        }else{           
            var latlng_arr = (cur_latlng)?cur_latlng.split('_'):[];
            if(latlng_arr.length === 2){  
                var latitude = latlng_arr[0];
                var longitude = latlng_arr[1];
                showCurrentAddress(latitude,longitude)
            }
        }
        
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
           // Cookies.set("address-search",$(input).val(),{expires:1, path: '/' });
            setCookieServer(latitude,longitude);
        });        
        $("#more_result").on('click',function(e){
            e.preventDefault();
            var token = $("#page_token").val();
            getRestaurantGoogle(token);
        });
    });
    
    function getNewLatlng(){
        var startPos;
        var geoOptions = {
            maximumAge: 5 * 60 * 1000,
            timeout: 10 * 1000,
            enableHighAccuracy: true
        }
        var geoSuccess = function(position) {
            startPos = position;                                                                    
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
                   location.reload();
                }
                
                setTimeout(function() {
                   $.loader.close();
                }, 10000);
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
                    $("#search_location").val(current_address);
                }
            } else {
                console.log("Geocoder failed due to: " + status);
            }
        });         
    }    
    function getRestaurantGoogle(token){
        $.ajax({
            method: "POST",
            url: "/ajax/restos-google",
            data: { page_token: token },
            beforeSend: function( xhr ) {
                $.loader.open();
            }
            })
            .done(function( data ) {                
                if(data.status == 'ok'){
                    var restaurants = data.data.restaurants;
                    for(var i = 0;i<restaurants.length;i++){
                        if(restaurants[i].id){
                            var id = restaurants[i].id;
                        }else{                
                            var id = restaurants[i].place_id;
                        }
                        var html = '';
                        html += ' <div class="col-md-10 col-md-offset-1 margin-bottom">';
                        html += '<div class="col-md-10  panel panel-primary">'; 
                        html += '<div class="row"><div class="col-md-9"><span class="text-bold"> <strong>'+restaurants[i].name+'</strong></span></div>';
                        html += '<div class="col-md-3"><span class="pull-right">'+restaurants[i].distance+' km</span></div></div>'; 
                        html += '<div class="row"><div class="col-md-9"><span>'+restaurants[i].address+' </span></div>'; 
                        html += '<div class="col-md-3">';
                        html += '<span class="badge pull-right" style="background: violet">'+restaurants[i].menus_count+'</span>';
                        html += '</div></div></div>'; 
                        html +=' <div class="col-md-2">'; 
                        html += '<a href="/admin/menu/add/step-2/'+id+'" class="link">'; 
                        html += '<span class="btn btn-danger">'; 
                        html += '<i class="fa fa-plus"></i> Ajout plat'; 
                        html += '</span></a></div></div>'; 
                        $('#restaurant_list').append(html);
                    }
                    
                    if(data.data.next_page !== ''){
                        $("#page_token").val(data.data.next_page);
                    }else{
                        $("#more_result_div").remove();
                    }
                    
                    setTimeout(function() {
                        $.loader.close();
                    },  1000);
                }
            });
    }
</script>
@endsection        
