@extends('layouts.app_homepage')

@section('content')
<div class="container">
    <div class="row">        
            <div class="col-md-12"> 
                <div class="panel panel-info">
                   <!-- <div class="panel-title panel-title-general">
                       @include('layouts.partials.restaurant_tabs',['active_tab'=>'restaurant'])
                    </div>-->
                    <div class="panel-body">   
                        <div class="row">  
                        <!--/stories-->
                        @foreach ($res_items as $item)
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                        <h3><a href="{{route('restaurant_detail',['id'=>$item['id']])}}">{{$item->name}}</a></h3>                                      
                                        </div>
                                        <div class="col-md-8">                                           
                                            <h4><span class="info">{{$item->address}}</span></h4>                                           
                                        </div>
                                        <div class="col-md-2">
                                            @if ($item->distance >= 0)
                                                @if ($item->distance >= 1)
                                                {{round($item->distance,2)}}{{' km'}}
                                                @else
                                                {{round(($item->distance * 1000),0)}}{{' m'}}
                                                @endif
                                            @endif
                                            <p>
                                                @if ($item->status == 'active')
                                                <span class="label label-success">Ouvert</span>
                                                @else
                                                <span class="label label-danger">Fermé</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-md-2 ">
                                            <a href="javascript:void(0);" class="btn-fav-res" attr-id="{{$item->id}}"><i class="fa fa-heart fa-2x"></i></a>                                                                                
                                        </div>                                      
                                    </div>
                               <div class="col-md-12">
                                   <div class="col-md-12" style="height: 1px; background: #bce8f1; overflow: hidden;"></div>
                               </div>
                        @endforeach                        
                        <div class="text-center">
                            {!! $res_items->appends(['q' => request('q')])->links() !!}
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
@endsection 