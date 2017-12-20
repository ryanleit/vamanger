@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">              
            <div class="col-md-12"> 
                <div class="panel">
                    <div class="panel-title" style="margin-bottom: 3px;">
                        <div class="pull-left">
                        <ul class="nav nav-tabs">
                              @include('layouts.partials.restaurant_tabs',['active_tab'=>'dish'])   
                        </ul>
                        </div>
                    </div>
                    <div class="panel-body">
                        <!--/stories-->
                        @foreach ($res_items as $item)
                        <div class="row">    
                            <br>
                            <!--<div class="col-md-2 col-sm-3 text-center">
                                <a class="story-title" href="#"><img alt="" src="https://charitablebookings.org/tm365/wp-content/uploads/2017/02/van-innnTTTT.jpg" style="width:100px;height:100px" class="img-circle"></a>
                            </div>-->
                            <div class="col-md-12 ">
                                
                                <div class="row">
                                    <div class="col-md-9">
                                        <h3>{{$item->menu_name}}</h3>
                                        <!--<h4><span class="label label-default">{{$item->website}}</span></h4>-->
                                        <h4>
                                            <small style="font-family:courier,'new courier';" class="text-muted">Updated: {{$item->updated_at->format('m-d-Y')}}  • <a href="#detail" class="text-muted">View More</a></small>
                                        </h4>
                                        <h4><span class="info">
                                            @if ($item->distance >= 0)
                                                @if ($item->distance >= 1)
                                                {{round($item->distance,2)}}{{' km'}}
                                                @else
                                                {{round(($item->distance * 1000),2)}}{{' m'}}
                                                @endif
                                            @endif
                                        </span></h4>
                                    </div>
                                    <div class="col-md-3">
                                        <h4>{{$item->name}}</h4>
                                        <br/>
                                        {{$item->price}} $
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                        <hr>
                        @endforeach  
                        <div class="text-center">
                            {!! $res_items->appends(['q' => request('q'),'latitude' => request('latitude'),'longitude' => request('longitude')])->links() !!}
                        </div>
                        <hr>                        
                        <!--<a href="/" class="btn btn-primary pull-right btnNext">More <i class="glyphicon glyphicon-chevron-right"></i></a>-->
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection
