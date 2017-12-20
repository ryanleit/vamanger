@extends('layouts.app_homepage')

@section('content')
<div class="container">
    <div class="row">        
            <div class="col-md-12"> 
                <div class="panel">
                    <!--<div class="panel-title panel-title-general" style="margin-bottom: 3px;">
                        @include('layouts.partials.restaurant_tabs',['active_tab'=>'favorite'])                     
                    </div>-->
                    <div class="panel-body panel-body-general"> 
                        <div class="row">
                            @if (count($res_items)>0)
                            <!--/stories-->
                            @foreach ($res_items as $item)
                            <div class="panel  panel-info">                                                           
                                <div class="panel-body">                       
                                <div class="col-md-12">
                                    <h3><a href="{{route('restaurant_detail',['id'=>$item['id']])}}">{{$item->name}}</a></h3>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <h4>
                                                <small style="font-family:courier,'new courier';" class="text-muted">
                                                    @if($item->updated_at)
                                                    {!! trans('restaurants.updated_at') !!}: {{$item->updated_at->format('m-d-Y')}} 
                                                    @elseif($item->created_at)
                                                    {!! trans('restaurants.created_at') !!}: {{$item->created_at->format('m-d-Y')}} 
                                                    @endif 
                                                    • <a href="{{route('restaurant_detail',['id'=>$item['id']])}}" class="text-muted">{!! trans('restaurants.view_more') !!}</a>
                                                </small>
                                            </h4>
                                            <h4><span class="info">{{$item->address}}</span></h4>
                                            <div class="col-md-12">
                                                @if(count($item->menus) > 0)
                                                <div class="col-md-2">
                                                    <strong>{!! trans('restaurants.menus') !!}:</strong>
                                                </div>
                                                <div class="col-md-9">
                                                    @foreach($item->menus as $menu)
                                                    <div class="label-important text-info"><strong>{{$menu->name}}</strong></div>
                                                    <div class="label-important">{{ str_limit(stripslashes($menu->description),100)}}</div>
                                                    @endforeach
                                                </div>  
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            @if ($item->distance >= 0)
                                                @if ($item->distance >= 1)
                                                {{round($item->distance,2)}}{{' km'}}
                                                @else
                                                {{round(($item->distance * 1000),2)}}{{' m'}}
                                                @endif
                                            @endif
                                            <p>
                                                <p>
                                                @if ($item->status == 'active')
                                                <span class="label label-success">{!! trans('restaurants.open') !!}</span>
                                                @else
                                                <span class="label label-danger">{!! trans('restaurants.closed') !!}</span>
                                                @endif
                                                </p>
                                            </p>
                                        </div>
                                        <div class="col-md-2 ">
                                            <a href="javascript:void(0);" class="btn-fav-res" attr-id="{{$item->id}}"><i class="fa fa-heart fa-2x"></i></a>                                        
                                        </div>
                                    </div>
                                    <br>
                                </div>
                            </div>
                            </div>
                            @endforeach  
                            <div class="text-center">
                                {!! $res_items->appends(['q' => request('q')])->links() !!}
                            </div>                        
                            <hr>
                            @else
                            <div class="row">                                                             
                                <div class="col-md-12">
                                    <div class="text-center">
                                    <div class="alert alert-warning" style="height: 200px;">
                                        <strong> {!! trans('restaurants.data_is_empty') !!}.</strong>
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
@section('footer_js')
<script src="/js/favorite_restaurants.js"></script>  
@endsection     