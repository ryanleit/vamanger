@extends('layouts.admin')
@section('header_css')

@endsection
@section('content')
<section class="content-header">
    <!--<h1>
        General Form Elements
        <small>Preview</small>
    </h1>-->
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <!--<li><a href="/admin/users">Users</a></li>-->
        <li class="active">Edit Setting</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit User Setting</h3>                  
                </div>   
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
                     {!! Form::model($setting, [
                        'method' => 'PATCH',
                        'url' => ['/admin/setting', $setting->id],
                        'class' => 'form-horizontal'
                    ]) !!}
                    <div class="form-group {{ $errors->has('currency') ? 'has-error' : ''}}">
                        {!! Form::label('currency', trans('settings.currency'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::select('currency', currency()->all(), $setting->currency, ['id'=>'currency','class' => 'form-control select2']) !!}
                            {!! $errors->first('currency', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>          
                    <div class="form-group {{ $errors->has('language') ? 'has-error' : ''}}">
                       {!! Form::label('language', trans('settings.language'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::select('language', language()->all(), $setting->language, ['id'=>'language','class' => 'form-control select2']) !!}
                            {!! $errors->first('language', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    
                    <div class="form-group clearfix">
                        {!! Form::label('distance_unit', trans('settings.distance_unit'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">                            
                            {!! Form::select('distance_unit',['km'=>'Km','m'=>'M'], $setting->distance_unit, ['id'=>'distance_unit','class' => 'form-control select2']) !!}
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-md-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> {{trans("users.Update")}}</button>
                        <a href="{{ url('/admin/profile-detail') }}" class="btn btn-default"><i class="fa fa-reply" aria-hidden="true"></i> {{trans("users.Cancel")}}</a>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
<!-- End Map box -->
@endsection
@section('footer_js')
<link rel="stylesheet" href="/select2/css/select2.css" />
<style>.select2-container .select2-selection--single{height: 100%;}</style>
<script type="text/javascript" src='/select2/js/select2.js'></script>  
<script type="text/javascript">
    $( document ).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });   
        $(".select2").select2({
            placeholder: "Select...",
            allowClear: true,          
        });
    });
</script>

@endsection        
