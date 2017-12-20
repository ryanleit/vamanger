
@extends('layouts.admin')
@section('sidebar')
@include('layouts.partials.admin.main_sidebar',['id'=>$restaurant->id])
@endsection
@section('content')
<section class="content-header">
    <h1>
        Restaurants management
        <small>List</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
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
                        'url' => ['admin/restaurant/delete', $restaurant->id],
                        'style' => 'display:inline'
                        ]) !!}
                        {!! Form::button('<i class="fa fa-close"></i>', array(
                        'type' => 'submit',
                        'class' => 'btn btn-xs btn-danger close-box',
                        'title' => trans('restaurants.Delete'). ' Item',
                        'onclick'=>'return confirm("'.trans('restaurants.Confirm delete?').'")'
                        ));!!}
                        {!! Form::close() !!}
                    </div>
                </div>     
                {!! Form::model(  $restaurant, [
                'method' => 'PATCH',
                'url' => ['/admin/my-restaurant',   $restaurant->id],
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
                        {!! Form::label('name', trans('restaurants.name'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>          
                    <div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
                        {!! Form::label('address', trans('restaurants.address'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('address', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : ''}}">
                        {!! Form::label('phone', trans('restaurants.phone'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('phone', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                        {!! Form::label('email', trans('restaurants.email'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::email('email', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('code_postal') ? 'has-error' : ''}}">
                        {!! Form::label('code_postal', trans('restaurants.code_postal'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('code_postal', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('code_postal', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('ville') ? 'has-error' : ''}}">
                        {!! Form::label('ville', trans('restaurants.ville'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('ville', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('ville', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('siren') ? 'has-error' : ''}}">
                        {!! Form::label('siren', trans('restaurants.siren'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::number('siren', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('siren', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('ape') ? 'has-error' : ''}}">
                        {!! Form::label('ape', trans('restaurants.ape'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('ape', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('ape', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('year') ? 'has-error' : ''}}">
                        {!! Form::label('year', trans('restaurants.year'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::number('year', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('year', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('ca') ? 'has-error' : ''}}">
                        {!! Form::label('ca', trans('restaurants.ca'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::number('ca', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('ca', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('resultat') ? 'has-error' : ''}}">
                        {!! Form::label('resultat', trans('restaurants.resultat'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::number('resultat', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('resultat', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('effectif') ? 'has-error' : ''}}">
                        {!! Form::label('effectif', trans('restaurants.effectif'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::number('effectif', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('effectif', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('legal_naf') ? 'has-error' : ''}}">
                        {!! Form::label('legal_naf', trans('restaurants.legal_naf'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('legal_naf', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('legal_naf', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('legal_siret') ? 'has-error' : ''}}">
                        {!! Form::label('legal_siret', trans('restaurants.legal_siret'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('legal_siret', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('legal_siret', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('legal_effectif_min') ? 'has-error' : ''}}">
                        {!! Form::label('legal_effectif_min', trans('restaurants.legal_effectif_min'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::number('legal_effectif_min', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('legal_effectif_min', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('legal_effectif_max') ? 'has-error' : ''}}">
                        {!! Form::label('legal_effectif_max', trans('restaurants.legal_effectif_max'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::number('legal_effectif_max', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('legal_effectif_max', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                        {!! Form::label('description', trans('restaurants.description'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>          
                    <div class="form-group {{ $errors->has('lat') ? 'has-error' : ''}}">
                        {!! Form::label('lat', trans('restaurants.lat'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::number('lat', null, ['class' => 'form-control','step'=>'any']) !!}
                            {!! $errors->first('lat', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('lng') ? 'has-error' : ''}}">
                        {!! Form::label('lng', trans('restaurants.lng'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::number('lng', null, ['class' => 'form-control','step'=>'any']) !!}
                            {!! $errors->first('lng', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-8">
                            <!-- Trigger the modal with a button -->
                            <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#myModal">Search place</button>
                        </div>
                    </div>           
                    <div class="form-group {{ $errors->has('slug') ? 'has-error' : ''}}">
                        {!! Form::label('slug', trans('restaurants.slug'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('slug', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('slug', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
                        {!! Form::label('status', trans('restaurants.status'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::select('status',['active' => 'Active', 'inactive' => 'Disable'],   $restaurant->status, ['class' => 'form-control']) !!}
                            {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>           

                </div>
                <div class="box-footer">
                    <div class="col-md-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> {{trans("restaurants.Update")}}</button>
                        <a href="{{ url('/admin/my-restaurant/list') }}" class="btn btn-default"><i class="fa fa-reply" aria-hidden="true"></i> {{trans("restaurants.Cancel")}}</a>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
<!-- Begin Map box -->
<link rel="stylesheet" href="{{ asset('css/google-map.css') }}" />  
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Google map</h4>
            </div>
            <div class="modal-body" style="height: 500px;">
                <!-- Begin map google -->
                <div class="pac-card" id="pac-card">
                    <div>
                        <div id="title-map">
                            Search location
                        </div>
                        <br/>
                    </div>
                    <div id="pac-container">
                        <input id="pac-input" type="text" placeholder="Enter a location">
                    </div>
                </div>
                <div id="map"></div>
                <div id="infowindow-content">
                    <img src="" width="16" height="16" id="place-icon">
                    <span id="place-name"  class="title"></span><br>
                    <span id="place-address"></span>
                </div> 
                <!-- End map google -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<!-- End Map box -->
@endsection
@section('footer_js')
<script src="/assets/plugins/switch/static/js/bootstrap-switch.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsnpreE3XP96gzuyZd4wmyw2kQ_3zJ3v0&libraries=places"></script>   
<script src="/js/map-search-location.js"></script>  
@endsection        
