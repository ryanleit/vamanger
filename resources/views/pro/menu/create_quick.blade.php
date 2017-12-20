@extends('layouts.admin')
@section('sidebar')
@include('layouts.partials.admin.main_sidebar',['id'=>null])
@endsection
@section('content')
<section class="content-header">
    <h1>
        General Form Elements
        <small>Preview</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Menus list</a></li>
        <li class="active">Menu create</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Create menu</h3>
                </div> 
                <div class="box-body">               
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
                    <div class="col-md-6 col-md-offset-2 margin-bottom">                        
                        <div class="input-group">
                            <input class="form-control" id="search_location" name="search_location" placeholder="Search location">                               
                            <div class="input-group-btn">                                                                                                              
                                <button class="btn btn-default" type="button" id="get_current_latlng"><i class="glyphicon glyphicon-map-marker"></i></button>
                            </div>                                    
                        </div> 
                    </div>
                    <div class="col-md-6 col-md-offset-2 margin-bottom">
                        <a href="{{route('menu_add_quick_step2')}}" class="btn btn-block btn-info">Votre restaurant ne figure pas dans cette liste</a>
                    </div>
                    <div id="restaurant_list">
                    @foreach($restaurants as $restaurant)
                    <div class="col-md-6 col-md-offset-2 margin-bottom">                         
                        <div class="col-md-10  panel panel-primary">
                            <div class="row">
                                <div class="col-md-9">
                                <span class="text-bold"> {{$restaurant['name']}} </span>
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
                                <div class="col-md-9">
                                <span>{{$restaurant['address']}} </span>
                                </div>
                                <div class="col-md-3">
                                    <span class="badge pull-right" style="background: violet">{{$restaurant['menus_count']}}</span>
                                </div>
                            </div>                            
                        </div>                            
                        <div class="col-md-2">
                            <a href="{{route('menu_add_quick_step2',['restaurant_id'=>(!empty($restaurant['id']))?$restaurant['id']:$restaurant['place_id']])}}" class="link">
                                <span class="btn btn-danger">
                                     <i class="fa fa-plus"></i> Ajout plat
                                </span>
                            </a>
                        </div>
                    </div>
                    @endforeach
                    </div>
                    <div class="col-md-6 col-md-offset-2">
                        @if(!empty($next_page))
                        <div class="text-center" id="more_result_div">
                            <a href="javascript:void(0);" class="btn btn-warning" id="more_result">Afficher plus de restaurants...</a>
                            <input type="hidden" id="page_token" name="page_token" value="{{$next_page}}" />
                        </div>
                        @endif
                    </div>
                </div>
        </div>
    </div>
</section>
@endsection
@section('footer_js')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsnpreE3XP96gzuyZd4wmyw2kQ_3zJ3v0&libraries=places"></script>
<script src="{{ asset('js/js.cookie.js') }}"></script>
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
        $("#get_current_latlng").on('click',function(e){
            e.preventDefault();
            getNewLatlng();
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
            url: "/admin/ajax/restaurants",
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
                        html += ' <div class="col-md-6 col-md-offset-2 margin-bottom">';
                        html += '<div class="col-md-10  panel panel-primary">'; 
                        html += '<div class="row"><div class="col-md-9"><span class="text-bold"> '+restaurants[i].name+'</span></div><div class="col-md-3"><span class="pull-right">'+restaurants[i].distance+' km</span></div></div>'; 
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
