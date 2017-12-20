@extends('layouts.app_homepage')

@section('content')
<div class="container">
    <div class="row">              
        <div class="col-md-12">            
            <div class="row">
                <!--/stories-->
                <div class="panel  panel-info">                               
                    <div class="panel-body" style="min-height: 700px;"> 
                        <div class="col-md-12 margin-bottom" style="margin-top: 70px;">                                        
                            <div class="col-md-8 col-md-offset-2">
                                <div class="col-md-12 margin-bottom">
                                    <h3 class="text-primary text-center"><strong>Qu'avez vous envi de manger aujourd'hui ?</strong></h2>
                                </div>
                            </div>
                            <div class="col-md-9 col-md-offset-3 margin-bottom" style="margin-top: 40px;">
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
                            
                            <div class="col-md-9 col-md-offset-3 margin-bottom">
                                <form id="search_frm" action="{{route('home_search')}}">  
                                <div class="col-md-6 panel panel-success" style="padding :5px;">
                                                                       
                                        <div class="row">
                                            <div class="col-md-12">
                                            <?php $food_count = count($food_cats);?>
                                            @foreach($food_cats as $key=> $food)
                                            <div class="col-md-4"><label class="checkbox-inline text-success"><input type="checkbox" name="foods[]" value="{{$food->id}}" @if(in_array($food->id,request('foods',[]))){{'checked'}}@endif>{{$food->name}}</label></div>
                                            @if((($key+1)%3) == 0 && ($key+1) < $food_count)                                                    
                                            </div>
                                            <div class="col-md-12">                                                       
                                            @endif
                                            @endforeach 
                                            </div>
                                        </div>                                        
                                        <!--<div class="form-group" style="margin-top: 10px;">
                                            <div class="col-md-5">
                                                <input type="text" name="dish_name" placeholder="Enter dish name" class="form-control input-sm" value="{{request('dish_name')}}">
                                            </div>
                                            <div class="col-md-5">
                                                <input type="text" name="restaurant_name" placeholder="Enter resto name" class="form-control input-sm" value="{{request('restaurant_name')}}">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="submit" name="search" class="btn btn-primary input-sm">Search</button>
                                            </div>
                                        </div>-->
                                       
                                                                                                                                                      
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" name="search" class="btn btn-primary btn-sm pull-right">Search</button>
                                </div>
                                </form>
                            </div>
                           
                        </div>
                        
                        <!--/stories-->
                        <?php $admin = false;?>                         
                        @if( auth()->check())
                                @if(auth()->user()->hasRoleLevel([9,12]))
                                    <?php $admin = true;?>                                    
                                @endif
                        @endif
                        <div class="col-md-8 col-md-offset-2" style="margin-top: 50px;"> 
                            <div class="col-md-12">
                            @if(count($res_items) > 0)                            
                            @foreach ($res_items as $item)                              
                            <div class="col-md-12 margin-bottom panel panel-info">    
                                <div class="col-md-5">   
                                    <div class="row">
                                    <h4>
                                        <strong>{{$item->menu_name}}</strong> 
                                        @if($item->price > 0)
                                        <?php $symbol = (empty($item->currency))?'':currency()->symbol($item->currency);?>
                                        <span class="text-success pull-right">{{number($item->price)}} {{$symbol}}</span>                                                                       
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
                                            <li class="tag label label-success">{{$food->name}}</li>
                                            @endforeach                                                                    
                                        </ul>                                                                                                                
                                    </span>                                    
                                </div>                           
                                <div class="col-md-7">
                                    <div class="pull-right">
                                    <h4><a href="{{route('restaurant_detail',['id'=>$item->id])}}">{{$item->name}}</a></h4>
                                        <span class="info pull-right">
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
</div>
@endsection
@section('footer_js')
<script src="{{ asset('js/google_latlng.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var geocoder = new google.maps.Geocoder();
         $('#search_location').on('keydown', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                geocodeAddress(geocoder);
            }
        });        
        /*document.getElementById('search_geocode').addEventListener('click', function() {
          geocodeAddress(geocoder);
        });*/
    });
    function geocodeAddress(geocoder) {
        var address = document.getElementById('search_location').value;
        if(address != ''){
            geocoder.geocode({'address': address}, function(results, status) {
                if (status === 'OK') {                      
                    var res_latitude = results[0].geometry.location.lat();
                    var res_longitude = results[0].geometry.location.lng();
                    Cookies.set("address-search",$('#search_location').val(),{expires:1, path: '/' });
                    setCookieServer(res_latitude,res_longitude);        
                } else {
                  alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        }else{
            alert('Please enter address!');
        }
    }
</script>
@endsection 
