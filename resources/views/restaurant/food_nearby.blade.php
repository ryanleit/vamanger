@extends('layouts.app_homepage')

@section('content')
<div class="container">
    <div class="row">              
        <div class="col-md-12"> 
            <div class="panel panel-default">
                <!--<div class="panel-title panel-title-general" >
                    include('layouts.partials.restaurant_tabs',['active_tab'=>'dish']) 
                </div>-->
                <div class="panel-body panel-body-general">
                    <div class="row">
                        <!--/stories-->
                        <?php $admin = false;?>
                        @if( auth()->check())
                                @if(auth()->user()->hasRoleLevel([9,12]))
                                    <?php $admin = true;?>                                    
                                @endif
                        @endif
                        @if(count($res_items) > 0)
                        @foreach ($res_items as $item)
                        <div class="panel  panel-info">                               
                            
                            <div class="panel-body"> 
                                <div class="col-md-12">    
                                    <br>                                                                    
                                    <div class="col-md-5">   
                                        <div>
                                        <h4><strong>{{$item->menu_name}} </strong></h4> 
                                        @if($admin || (auth()->id() == $item->user_id))
                                        <a class="text-danger" href="{{route('menu_edit',['id'=>$item->menu_id])}}">Edit</a>                                       
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
                                        @if($item->price > 0)
                                        <?php $symbol = (empty($item->currency))?'':$restaurant->currency($item->currency);?>
                                        <p> {{number($item->price)}} {{$symbol}}</p>                                                                        
                                        @endif
                                    </div>
                                   
                                    <div class="col-md-3 col-md-offset-4">
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
                            </div>                                                                       
                        </div>                       
                        @endforeach  
                        <div class="text-center">
                            {!! $res_items->appends(['q' => request('q'),'latitude' => request('latitude'),'longitude' => request('longitude')])->links() !!}
                        </div>      
                        @else
                        <div class="panel  panel-info">                                                           
                            <div class="panel-body"> 
                                <div class="col-md-12 margin-bottom"> 
                                <div style="height: 500px;padding: 20px;text-align: center;">
                                        <strong> {{__('homepage.dish_emtpy')}} </strong>
                                </div>
                                </div>
                            </div>
                        </div>                        
                        @endif
                        <!--<a href="/" class="btn btn-primary pull-right btnNext">More <i class="glyphicon glyphicon-chevron-right"></i></a>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
