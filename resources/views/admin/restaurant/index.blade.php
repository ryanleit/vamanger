@extends('layouts.admin')

@section('header_css')
@endsection

@section('content')
<section class="content-header">
    <h1>
        Restaurants management
        <small>List</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Restaurant list</li>
    </ol>
</section>
<section class="content">    
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">                    
                    <div class=" col-md-2 pull-left">
                        <label class="control-label">Filter by status:</label>
                        <select class=" form-control" id="filter_status" name="filter_status">                           
                            <?php $verify_status = ['verified','pending','closed','trashed']; ?>
                            <option value="">All</option>
                            @foreach($verify_status as $stas)
                            <option value="{{$stas}}" {{($status == $stas)?'selected':''}}>{{title_case($stas)}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" id="query_url" name="query_url" value="<?php echo http_build_query(['order_by'=>$order_by,'order_direct'=>$order_direct,'search'=>$search,'status'=>'']); ?>" >
                    </div>
                    <div class=" col-md-4 pull-left">
                        <label class="control-label">Enter search:</label>
                        <form name="frm_search_text" action="{{route('admin_restaurant_list',['order_by'=>$order_by,'order_direct'=>$order_direct,'status'=>''])}}" method="GET">
                            <div class="form-inline">
                                <input type="text" class="form-control" name="search" id="search" value="{{$search}}" placeholder="Search in ID, name, address..." >
                                <input type="hidden" name="order_by" value="{{$order_by}}" >
                                <input type="hidden" name="order_direct" value="{{$order_by}}" >
                                <input type="hidden" name="status" value="{{$status}}" >
                                <input type="submit" class="btn btn-success" value="Search">
                            </div>
                        </form>
                    </div>
                    <div class="pull-right"><a href="{{route('restaurant_add')}}" class="btn btn-info">Add Restaurant</a></div>
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
                    <div class="table-responsive">
                        @if(count($restaurants) > 0)
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        ID
                                        <div class="btn-group pull-right">
                                            <a href="{{route('admin_restaurant_list',['order_by'=>'id','order_direct'=>'desc','status'=>$status,'search'=>$search])}}" class="@if($order_by=='id' and $order_direct=='desc') disabled @endif"><i class=" fa fa-sort-desc"></i></a>
                                            <a href="{{route('admin_restaurant_list',['order_by'=>'id','order_direct'=>'asc','status'=>$status,'search'=>$search])}}" class="@if($order_by=='id' and $order_direct=='asc') disabled @endif"><i class="fa fa-sort-asc"></i></a>
                                        </div>
                                    </th>
                                    <th>
                                        Name
                                        <div class="btn-group pull-right">
                                            <a href="{{route('admin_restaurant_list',['order_by'=>'name','order_direct'=>'desc','status'=>$status,'search'=>$search])}}" class="@if($order_by=='name' and $order_direct=='desc') disabled @endif"><i class=" fa fa-sort-desc"></i></a>
                                            <a href="{{route('admin_restaurant_list',['order_by'=>'name','order_direct'=>'asc','status'=>$status,'search'=>$search])}}" class=" @if($order_by=='name' and $order_direct=='asc') disabled @endif"><i class="fa fa-sort-asc"></i></a>
                                        </div>
                                    </th>                                    
                                    <th>Address</th>  
                                    <th>View count</th>
                                    <th>Menu count</th>   
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($restaurants as $restaurant)
                                <tr>
                                    <td @if($order_by == 'id') class="active" @endif>{{ $restaurant->id }}</td>
                                    <td @if($order_by == 'name') class="active" @endif>{{ $restaurant->name }}</td>                                    
                                    <td @if($order_by == 'address') class="active" @endif>{{ $restaurant->address }}</td>
                                    <td>{{ $restaurant->view_count }}</td>
                                    <td><a href="{{route('menu_list',['id'=>$restaurant->id])}}" class="btn btn-success">{{ count($restaurant->menus) }}</a></td>
                                    <td class="text-center">
                                        <a href="/admin/restaurant/edit/{{$restaurant->id}}" class="btn btn-info" > Edit </a>
                                        {!! Form::open([
                                        'method'=>'DELETE',
                                        'url' => ['admin/restaurant/delete', $restaurant->id],
                                        'style' => 'display:inline'
                                        ]) !!}
                                        {!! Form::button('<i class="fa fa-remove"></i>', array(
                                        'type' => 'submit',
                                        'class' => 'btn btn-danger',
                                        'title' => trans('restaurants.Delete'). ' Item',
                                        'onclick'=>'return confirm("'.trans('restaurants.Confirm delete?').'")'
                                        ));!!}
                                        {!! Form::close() !!}
                                        <!--<a href="#edit" class="btn btn-danger" > Del </a>-->
                                    </td>
                                </tr>
                                @endforeach                                                               
                            </tbody>
                        </table>
                        @else
                        <div class="alert alert-info alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <strong>Data not found</strong>
                        </div>
                        @endif
                    </div>
                    <div class="text-center">
                        {!! $restaurants->appends(['order_by' => request('order_by'),'order_direct' => request('order_direct'),'status' => request('status'),'search'=>$search])->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>                 
</section>
@endsection
@section('footer_js')
<script>
$(document).ready(function () {
    $("#filter_status").on('change',function(){
        var status = $(this).val();
        var query_url = $('#query_url').val();
        document.location = "/admin/restaurants/?"+query_url+status;
    });
});
</script>
@endsection