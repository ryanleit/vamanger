@extends('layouts.admin')
@section('sidebar')
@include('layouts.partials.admin.main_sidebar',['id'=>$menu->restaurant_id])
@endsection
@section('content')
<section class="content-header">
    <h1>
        General Form Elements
        <small>Preview</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">General Elements</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Create Restaurant</h3>
                    <div class="pull-right">
                        {!! Form::open([
                        'method'=>'DELETE',
                        'url' => ['admin/menu/delete', $menu->id],
                        'style' => 'display:inline'
                        ]) !!}
                        {!! Form::button('<i class="fa fa-close"></i>', array(
                        'type' => 'submit',
                        'class' => 'btn btn-xs btn-danger close-box',
                        'title' => trans('menus.Delete'). ' Item',
                        'onclick'=>'return confirm("'.trans('menus.Confirm delete?').'")'
                        ));!!}
                        {!! Form::close() !!}
                    </div>
                </div>                            
                {!! Form::open(['url' => ['/admin/menu', $menu->id],'id' => 'frm_password_change', 'class' => 'form-horizontal','method' => 'PATCH']) !!}            
                <div class="box-body">               
                    @if (session()->has('success_message'))
                        <div class="alert alert-success">
                            {{ session()->get('success_message') }}
                        </div>
                    @endif
                    @if (session()->has('fail_message'))
                        <div class="alert alert-danger">
                            {{ session()->get('fail_message') }}
                        </div>
                    @endif

                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                        {!! Form::label('name', trans('menus.name'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('name', $menu->name, ['class' => 'form-control', 'required' => 'required']) !!}
                            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>   
                    <div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
                        {!! Form::label('price', trans('menus.price'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">                           
                            {!! Form::text('price', number($menu->price), ['class' => 'form-control']) !!}
                            {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>   
                    <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                        {!! Form::label('description', trans('menus.description'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::textarea('description', $menu->description, ['class' => 'form-control']) !!}
                            {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label"> Dish </label>
                        <div class="col-md-6">
                            @foreach($food_cats as $food)
                            <label class="checkbox-inline"><input type="checkbox" name="foods[]" value="{{$food->id}}" @if(in_array($food->id,$foodIds)) {{'checked'}} @endif>{{$food->name}}</label>
                            @endforeach                    
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('category_id') ? 'has-error' : ''}}">
                        {!! Form::label('category_id', trans('menus.category_id'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::select('category_id',$categories, $menu->category_id, ['class' => 'form-control']) !!}
                            {!! $errors->first('category_id', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>             
                    <div class="form-group {{ $errors->has('from_date') ? 'has-error' : ''}}">
                        <label class="col-md-2 control-label">Set date</label>
                        <div class="col-md-6">                            
                            {!! Form::date('from_date',date('Y-m-d',strtotime($menu->from_date)), ['class' => 'datepicker']) !!}
                            {!! $errors->first('from_date', '<p class="help-block">:message</p>') !!} 
                        </div>

                    </div>
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
                        {!! Form::label('status', trans('menus.status'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::select('status',['active' => 'Active', 'inactive' => 'Disable'], $menu->status, ['class' => 'form-control']) !!}
                            {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>          


                </div>
                <div class="box-footer">
                    <div class="col-md-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> {{trans("menus.Update")}}</button>
                        <a href="{{ url('/admin/menus/'.$menu->restaurant_id) }}" class="btn btn-default"><i class="fa fa-reply" aria-hidden="true"></i> {{trans("menus.Cancel")}}</a>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
@endsection
@section('footer_js')
<link rel="stylesheet" href="/AdminLTE/plugins/datepicker/datepicker3.css" />
<script src="/AdminLTE/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="/AdminLTE/plugins/datepicker/locales/bootstrap-datepicker.fr.js"></script>
<script type="text/javascript">
$('.datepicker').datepicker({
    format: 'yyyy-mm-dd',
    autoclose: true,
    language:'fr'
});
</script>
@endsection        
