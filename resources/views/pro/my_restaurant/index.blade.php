@extends('layouts.admin')

@section('header_css')
@endsection

@section('content')
<section class="content-header">
    <h1>
        Restaurants management
        <small>List</small>
    </h1>    
</section>
<section class="content">    
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
               <!-- <div class="box-header">
                    Items list
                    <div class="pull-right"><a href="{{route('restaurant_add')}}" class="btn btn-info">Add Restaurant</a></div>
                </div>-->
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
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>
                                        ID
                                        <div class="btn-group pull-right">
                                            <a href="{{url('admin/my-restaurant/list?order_by=id&order_direct=desc')}}" class="@if($order_by=='id' and $order_direct=='desc') disabled @endif"><i class=" fa fa-sort-desc"></i></a>
                                            <a href="{{url('admin/my-restaurant/list?order_by=id&order_direct=asc')}}" class="@if($order_by=='id' and $order_direct=='asc') disabled @endif"><i class="fa fa-sort-asc"></i></a>
                                        </div>
                                    </th>
                                    <th>
                                        Name
                                        <div class="btn-group pull-right">
                                            <a href="{{url('admin/my-restaurant/list?order_by=name&order_direct=desc')}}" class="@if($order_by=='name' and $order_direct=='desc') disabled @endif"><i class=" fa fa-sort-desc"></i></a>
                                            <a href="{{url('admin/my-restaurant/list?order_by=name&order_direct=asc')}}" class=" @if($order_by=='name' and $order_direct=='asc') disabled @endif"><i class="fa fa-sort-asc"></i></a>
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
                                    <td>
                                        <a href="{{route('menu_list',['id'=>$restaurant->id])}}" class="btn btn-success">{{ count($restaurant->menus) }}</a>
                                        |
                                        <a href="{{route('menu_create',['id'=>$restaurant->id])}}" class="btn btn-green">Add dish</a>
                                    </td>
                                    <td class="text-center">
                                        <a href="/admin/my-restaurant/{{$restaurant->id}}" class="btn btn-info" > Edit </a>
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
                    </div>
                    <div class="text-center">
                        {!! $restaurants->appends(['order_by' => request('order_by'),'order_direct' => request('order_direct')])->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>                 
</section>
@endsection
@section('footer_js')
<script src="/AdminLTE/plugins/dataTables/jquery.dataTables.js"></script>
<script src="/AdminLTE/plugins/dataTables/dataTables.bootstrap.js"></script>
<script>
$(document).ready(function () {
    //$('#dataTables-example').dataTable();
});
</script>
@endsection