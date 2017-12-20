@extends('layouts.admin')
@section('sidebar')
@include('layouts.partials.admin.main_sidebar',['id'=>$food->restaurant_id])
@endsection
@section('content')
<section class="content-header">    
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="/admin/dishes">Dishes</a></li>
        <li class="active">Edit dish</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit Dish</h3>
                    <div class="pull-right">
                        {!! Form::open([
                        'method'=>'DELETE',
                        'url' => ['admin/dish/delete', $food->id],
                        'style' => 'display:inline'
                        ]) !!}
                        {!! Form::button('<i class="fa fa-close"></i>', array(
                        'type' => 'submit',
                        'class' => 'btn btn-xs btn-danger close-box',
                        'title' => trans('dishes.Delete'). ' Item',
                        'onclick'=>'return confirm("'.trans('dishes.Confirm delete?').'")'
                        ));!!}
                        {!! Form::close() !!}
                    </div>
                </div>              
                {!! Form::model($food, [
                'method' => 'PATCH',
                'url' => ['/admin/dish/update', $food->id],
                'class' => 'form-horizontal'
                ]) !!}
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
                        {!! Form::label('name', trans('dishes.name'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>   
                    
                    <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                        {!! Form::label('description', trans('dishes.description'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
                        {!! Form::label('status', trans('dishes.status'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::select('status',['active' => 'Active', 'inactive' => 'Disable','deleted' => 'Deleted'], $food->status, ['class' => 'form-control']) !!}
                            {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>          


                </div>
                <div class="box-footer">
                    <div class="col-md-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> {{trans("dishes.Update")}}</button>
                        <a href="{{ url('/admin/dishes') }}" class="btn btn-default"><i class="fa fa-reply" aria-hidden="true"></i> {{trans("dishes.Cancel")}}</a>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
@endsection
@section('footer_js')
<script src="/AdminLTE/plugins/datepicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
$('.datepicker').datepicker({
    format: 'yyyy-mm-dd'
});
</script>
@endsection        
