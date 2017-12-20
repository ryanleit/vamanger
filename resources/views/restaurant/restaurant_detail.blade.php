@extends('layouts.app_homepage')

@section('content')
<div class="container">
    <div class="row">              
        <div class="col-md-12"> 
            <div class="panel">
                <div class="panel-title">                  
                    <div class="row">    
                        <div class="col-md-12 ">
                            <div class="col-md-11 ">
                                <h3 class="blue">{{$restaurant['name']}}</h3>                                
                                @if( auth()->check())
                                    @if(auth()->user()->hasRoleLevel([9,12]) || (auth()->id() == $restaurant['user_id']))
                                    <a class="btn btn-primary" href="{{route('menu_list',['id'=>$restaurant['id']])}}">Edit</a>
                                    @endif
                                @endif
                            </div>
                            <div class="col-md-1 ">                            
                                <ul class="nav nav-tabs">
                                    <li class="tabs-list-li active"><a attr-id="1" href="/" class="tabs-list">{!! trans('restaurants.back') !!}</a></li>
                                </ul>                           
                            </div>
                        </div>
                    </div>                     
                </div>
                <div class="panel-body">
                    <!--/stories-->
                    <div class="row">    
                        <br>                          
                            <div class="col-md-12 ">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-md-4">
                                            <h4>{!! trans('restaurants.address') !!}: <a title="Map" rel="nofollow" target="_blank" href="javascript:void(0)" onclick="window.open('https://www.google.com.sg/maps/search/{{$restaurant["lat"]}},{{$restaurant["lng"]}}', '_blank');"><i class="fa fa-map-marker"></i></a>
                                                {{$restaurant['address']}}
                                            </h4>                                             
                                            <h4><small class="text-muted">{!! trans('restaurants.updated_on')!!}: {{date('m-d-Y',strtotime($restaurant['updated_at']))}}  • <a href="#detail" class="text-muted">{!! trans('restaurants.10_display_today')!!}</a></small></h4>
                                        </div> 
                                        <div class="col-md-4">
                                           <h4>{!! trans('restaurants.contact') !!}: <a href="#"><i class="glyphicon glyphicon-earphone"></i> {{$restaurant['phone']}}</a></h4>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="col-md-2 col-md-offset-10">
                                            <a href="javascript:void(0);" class="btn-fav-res" attr-id="{{$restaurant['id']}}"><i class="fa fa-heart fa-2x"></i></a>
                                            </div>
                                        </div>                                    
                                    </div>                                          
                                    <div class="col-md-12">  
                                        <div class="center-block">
                                        <div id="map"></div>
                                        <input type="hidden" name="lat_des" id="lat_des" value="{{$restaurant['lat']}}" />
                                        <input type="hidden" name="lng_des" id="lng_des" value="{{$restaurant['lng']}}" />
                                        <input type="hidden" name="lat_ori" id="lat_ori" value="{{$lat}}" />
                                        <input type="hidden" name="lng_ori" id="lng_ori" value="{{$lng}}" />
                                        </div>
                                    </div>                                                                                                       
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        
                                        <ul class="nav nav-tabs" id="menus_list">
                                            <li class="{{($date==$date_arr['preDt'])?'active':''}}"><a href="{{route('restaurant_detail',['id'=>$restaurant['id'],'date'=>$date_arr['preDt']])}}#menus_list">&lt;&lt; {!! trans('restaurants.yesterday') !!}</a></li>
                                            <li class="{{($date==$date_arr['today'])?'active':''}}"><a href="{{route('restaurant_detail',['id'=>$restaurant['id'],'date'=>$date_arr['today']])}}#menus_list">{!! trans('restaurants.today') !!}</a></li>
                                            <li class="{{($date==$date_arr['nextDt'])?'active':''}}"><a href="{{route('restaurant_detail',['id'=>$restaurant['id'],'date'=>$date_arr['nextDt']])}}#menus_list">{!! trans('restaurants.tomorrow') !!} &gt;&gt;</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="panel panel-info">
                                                <div class="box-body">
                                                @if (!empty($menus))
                                                    @foreach ($menus as $menu)
                                                    <div class="row"  >
                                                            <div class="col-md-9">  
                                                                <div class="col-md-10">
                                                                    <h4 class="bg-info"><strong class="text-danger">{{$menu['name']}}</strong></h4>                                        
                                                                </div>                                                                

                                                                <div class="col-md-10">
                                                                <span>
                                                                    <small>{{$menu['description']}}</small>
                                                                </span>                                        
                                                                <span >
                                                                    <p>
                                                                        <ul class="list-inline">
                                                                            @foreach ($menu['foods'] as $cat)
                                                                            <li class="list-group-item-success">{{$cat['name']}} </li>
                                                                            @endforeach                                                                    
                                                                        </ul>                                                                
                                                                    </p>                                                                                    
                                                                </span>

                                                                </div>

                                                            </div>
                                                            <div class="col-md-2">
                                                                @if($menu['price'] > 0)
                                                                <?php $symbol = (empty($restaurant->currency))?'':currency()->symbol($restaurant->currency)?>
                                                                <h4 class="pull-right">{{number($menu['price'])}} {{$symbol}}</h4>   
                                                                @endif
                                                            </div>
                                                    </div>
                                                    @endforeach
                                                @else
                                                <div class="alert alert-info">{!! trans('restaurants.have_not_menu') !!}</div>
                                                @endif
                                                </div>
                                               </div>                                      
                                        </div>                                       
                                    </div>
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
<script src="/js/favorite_restaurants.js"></script>  
<script type="text/javascript">
   
    function setMakerMap(position) {
      
      var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: position
      });
      var marker = new google.maps.Marker({
        position: position,
        map: map
      });            
    }
    function getDirection(lat,lng,lat_ori,lng_ori){        
        var directionsService = new google.maps.DirectionsService;
        var directionsDisplay = new google.maps.DirectionsRenderer;
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 10,
          center: {lat: lat, lng: lng}
        });
        directionsDisplay.setMap(map);
        
        directionsService.route({
            origin: {lat: lat_ori, lng: lng_ori},
            destination:{lat: lat, lng: lng},
            travelMode: 'DRIVING'
        }, function(response, status) {
            if (status === 'OK') {
                directionsDisplay.setDirections(response);
            } else {
                //window.alert('Directions request failed due to ' + status);  
                setMakerMap({lat: lat, lng: lng});
            }
        });               
    }    
    $( document ).ready(function() {
        var lat_des = Number($("#lat_des").val());
        var lng_des = Number($("#lng_des").val());
        var lat_ori = Number($("#lat_ori").val());
        var lng_ori = Number($("#lng_ori").val());
               
        getDirection(lat_des,lng_des, lat_ori,lng_ori)     
        //initMap();      
    })
</script>
    
<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsnpreE3XP96gzuyZd4wmyw2kQ_3zJ3v0"></script>   -->
@endsection   