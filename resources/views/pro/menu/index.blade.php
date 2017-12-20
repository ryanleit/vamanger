@extends('layouts.admin')

@section('header_css')

@endsection

@section('sidebar')
@include('layouts.partials.admin.main_sidebar',['id'=>$restaurant->id])
@endsection

@section('content')
<section class="content-header">
    <h1>
        Menus management
        <small>List</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">Restaurant list</li>
    </ol>
</section>
<section class="content">    
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">
                    Menu list
                    <div class="pull-right">
                        <a href="{{route('menu_add',['id'=>$restaurant->id])}}"class="btn btn-info"> Ajout plat</a>
                    </div>
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
                    <div class="text-primary text-center bg-gray"><h3>Today dish</h3></div>
                    @if(count($menusToday) >0)                    
                    <div class="table-responsive">
                        <table class="table table-hover" id="menu_table">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Price</th>               
                                    <th>Status</th>               
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($menusToday as $menu)                               
                                <tr class="bg-info text-white">
                                    <td @if($order_by == 'id') class="active" @endif>{{ $menu->name }}</td>
                                    <td @if($order_by == 'price') class="active" @endif>{{ number($menu->price) }}</td>                                    
                                    <td @if($order_by == 'status') class="active" @endif>{{ $menu->status }}</td>
                                    <td class="text-center">
                                        <a href="/admin/menu/{{$menu->id}}" class="btn btn-info" > Edit </a>
                                        {!! Form::open([
                                        'method'=>'DELETE',
                                        'url' => ['admin/menu/delete', $menu->id],
                                        'style' => 'display:inline'
                                        ]) !!}
                                        {!! Form::button('<i class="fa fa-remove"></i>', array(
                                        'type' => 'submit',
                                        'class' => 'btn btn-danger',
                                        'title' => trans('items.Delete'). ' Item',
                                        'onclick'=>'return confirm("'.trans('menus.Confirm delete?').'")'
                                        ));!!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                                @endforeach                                                               
                            </tbody>
                        </table>
                        <div class="text-center">
                            {!! $menusToday->links() !!}
                        </div>
                    </div>
                    @else
                    <div class="alert alert-warning">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        Have not dish for today
                    </div>
                    @endif
                    

                </div>
            </div>
            <div class="box">
                <div class="text-primary text-center bg-gray"><h3>Other dish</h3></div>
                <div class="table-responsive">
                    <table class="table table-hover" id="menu_table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Price</th>               
                                <th>Status</th>               
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($menus as $menu)                                
                            <tr>
                                <td @if($order_by == 'id') class="active" @endif>{{ $menu->name }}</td>
                                <td @if($order_by == 'title') class="active" @endif>{{ number($menu->price) }}</td>                                    
                                <td @if($order_by == 'status') class="active" @endif>{{ $menu->status }}</td>
                                <td class="text-center">
                                    <a href="/admin/menu/{{$menu->id}}" class="btn btn-info" > Edit </a>
                                    {!! Form::open([
                                    'method'=>'DELETE',
                                    'url' => ['admin/menu/delete', $menu->id],
                                    'style' => 'display:inline'
                                    ]) !!}
                                    {!! Form::button('<i class="fa fa-remove"></i>', array(
                                    'type' => 'submit',
                                    'class' => 'btn btn-danger',
                                    'title' => trans('items.Delete'). ' Item',
                                    'onclick'=>'return confirm("'.trans('menus.Confirm delete?').'")'
                                    ));!!}
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                            @endforeach                                                               
                        </tbody>
                    </table>
                    <div class="text-center">
                        {!! $menus->links() !!}
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
    //$('#dataTables-example').dataTable();
});
</script>
@endsection