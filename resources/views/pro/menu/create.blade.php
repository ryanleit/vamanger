@extends('layouts.admin')
@section('sidebar')
@include('layouts.partials.admin.main_sidebar',['id'=>$restaurant_id])
@endsection
@section('content')
<section class="content-header">
    <h1>
        General Form Elements
        <small>Preview</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Menus list</a></li>
        <li class="active">Menu create</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Create menu</h3>
                </div> 
                {!! Form::open(['url' => route('menu_create',['id'=>$restaurant_id]), 'class' => 'form-horizontal','method' => 'post']) !!}
                <div class="box-body">               
                    @if(Session::has('fail_message'))
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {{ Session::get('fail_message') }}
                    </div>
                    @endif
                    @if(Session::has('flash_message'))
                    <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        {{ Session::get('success_message') }}
                    </div>
                    @endif

                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                        {!! Form::label('name', trans('menus.name'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>   
                    <div class="form-group {{ $errors->has('price') ? 'has-error' : ''}}">
                        {!! Form::label('price', trans('menus.price'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('price', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>   
                    <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                        {!! Form::label('description', trans('menus.description'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-lg-2 control-label"> Dish </label>
                        <div class="col-md-6">
                            @foreach($food_cats as $food)
                            <label class="checkbox-inline"><input type="checkbox" name="foods[]" value="{{$food->id}}" >{{$food->name}}</label>
                            @endforeach                    
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('category_id') ? 'has-error' : ''}}">
                        {!! Form::label('category_id', trans('menus.category_id'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::select('category_id',$categories, 2, ['class' => 'form-control']) !!}
                            {!! $errors->first('category_id', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>             
                    <div class="form-group {{ $errors->has('from_date') ? 'has-error' : ''}}">
                        <label class="col-md-2 control-label">Set date</label>
                        <div class="col-md-6">
                            {!! Form::date('from_date',date('Y-m-d'), ['class' => 'form-control datepicker']) !!}
                            {!! $errors->first('from_date', '<p class="help-block">:message</p>') !!}                                
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
                        {!! Form::label('status', trans('menus.status'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::select('status',['active' => 'Active', 'inactive' => 'Disable'], null, ['class' => 'form-control']) !!}
                            {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>                      

                </div>
                <div class="box-footer">
                    <div class="col-md-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> {{trans("menus.Create")}}</button>
                        <a href="{{ url('/admin/menus/'.$restaurant_id) }}" class="btn btn-default"><i class="fa fa-reply" aria-hidden="true"></i> {{trans("menus.Cancel")}}</a>
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
    regional:'fr'
});
</script>
@endsection        
