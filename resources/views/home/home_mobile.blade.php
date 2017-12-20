@extends('layouts.app_homepage')

@section('content')
<div class="container">
    <div class="row">              
        <div class="col-md-12">            
            <div class="row">
                <!--/stories-->
                <div class="panel  panel-info">                               
                    <div class="panel-body" style="min-height: 700px;">                  
                        
                        <!--/stories-->
                        <?php $admin = false;?>
                        @if( auth()->check())
                                @if(auth()->user()->hasRoleLevel([9,12]))
                                    <?php $admin = true;?>                                    
                                @endif
                        @endif
                        <div class="col-md-10 col-md-offset-1">   
                            @if(count($res_items) > 0)
                            @foreach ($res_items as $item)                    
                            <div class="col-md-12 margin-bottom">    

                                <div class="col-md-5">   
                                    <div>
                                    <h4>
                                        <strong>{{$item->menu_name}}</strong> 
                                        @if($item->price > 0)
                                        <?php $symbol = (empty($item->currency))?'EUR':$item->currency?>
                                        <span class="text-success pull-right">{{number($item->price)}} {{currency()->symbol($symbol)}}</span>                                                                       
                                        @endif
                                    </h4> 
                                    @if($admin || (auth()->id() == $item->user_id))
                                    <span>
                                    <a class="text-danger" href="{{route('menu_edit',['id'=>$item->menu_id])}}">Edit</a>                                       
                                    |
                                    <a class="text-danger" href="{{route('menu_del',['id'=>$item->menu_id])}}">Delete</a>
                                    </span>
                                    @endif
                                    </div>
                                    <span>
                                        @if($item->menu_des)                                            
                                        {{str_limit(stripslashes($item->menu_des),100)}}
                                        @endif
                                    </span>                                        
                                    <span>                                                                                               
                                        <ul class="list-inline">
                                            @foreach($item->foods as $food)
                                            <li class="list-group-item-info">{{$food->name}}</li>
                                            @endforeach                                                                    
                                        </ul>                                                                                                                
                                    </span>                                    
                                </div>                           
                                <div class="col-md-7">
                                    
                                    <h4><a href="{{route('restaurant_detail',['id'=>$item->id])}}">{{$item->name}}</a></h4>
                                    <span class="info">
                                        @if ($item->distance >= 0)
                                            @if ($item->distance >= 1)
                                            {{round($item->distance,2)}}{{' km'}}
                                            @else
                                            {{round(($item->distance * 1000),0)}}{{' m'}}
                                            @endif
                                        @endif
                                    </span>                                 
                                </div>                                    
                            </div>
                            <div class="col-md-12">
                                   <div class="col-md-12" style="height: 1px; background: #bce8f1; overflow: hidden;"></div>
                            </div>
                            @endforeach  
                            <div class="text-center">
                                {!! $res_items->appends(['q' => request('q'),'latitude' => request('latitude'),'longitude' => request('longitude')])->links() !!}
                            </div>  
                            @else
                            <div class="col-md-12 margin-bottom alert  alert-info"> 
                                <div style="height: 100px;padding: 20px;text-align: center;">
                                        <strong> {{__('homepage.dish_emtpy')}} </strong>
                                </div>
                            </div>
                            @endif
                        </div> 
                        
                    </div>
                </div>                                                                       
            </div>                       
        </div>
    </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsnpreE3XP96gzuyZd4wmyw2kQ_3zJ3v0&libraries=places"></script>
<script type="text/javascript">
    var latitude = "";
    var longitude = "";     
    $( document ).ready(function() {       
        var cur_latlng = Cookies.get("latlng");  
        
        if(!cur_latlng){  
            getNewLatlng();
        }
    });
    
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
    /**
    * 
    * @param {type} lat_val
    * @param {type} lng_val
    * @returns {undefined}     */
    function setCookieServer(lat_val,lng_val){
        $.ajax({
            method: "GET",
            url: "/cookie/latlng",
            data: { lat: lat_val, lng: lng_val }
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
                }
            });
    }   
</script>
@endsection
