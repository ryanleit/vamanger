@extends('layouts.admin')
@section('header_css')

@endsection
@section('content')
<section class="content-header">
    <h1>
        Restaurant Management
    </h1>
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="/admin/restaurants">Restaurants</a></li>
        <li class="active">Restaurant add</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Create Restaurant</h3>
                </div>         
                {!! Form::open(['url' => '/admin/restaurant/create','id' => 'frm_item_add', 'class' => 'form-horizontal','method' => 'post']) !!}
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
                    @if (session()->has('merge_message'))
                        <div class="col-md-12  alert alert-info">
                            <div class="col-md-6 col-md-offset-2">
                                {!! session()->get('merge_message') !!}
                            </div>                            
                            @if(request('mer_id'))
                            <div class="col-md-6 col-md-offset-2">
                                <div class="col-md-4"><a href="{{route('restaurant_edit',['id'=>request('mer_id')])}}" id="merge_data" class="btn btn-warning" target="_blank">Merge data</a></div>
                                <div class="col-md-4"><a href="javascript:void(0);" id="force_add" class="btn btn-primary" >Continuous add</a></div>
                                <input type="hidden" name="mer_id" id="mer_id" value="{{request('mer_id')}}">
                                <input type="hidden" name="force_option" id="force_option">
                            </div>
                            @endif
                        </div>
                    @endif
                    <div id="form_error_mess">
                        
                    </div>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                        {!! Form::label('name', trans('restaurants.name'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>               
                   
                    <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                        <div>
                        <label for="phone" class="col-md-2 control-label">Phone</label>
                        <div class="col-md-6">  
                            {!! Form::text('phone', null, ['class' => 'form-control','id'=>'phone','placeholder'=>'+84902686559']) !!}                            
                        </div>
                        </div>
                        <div  class="col-md-6 col-md-offset-4">
                            @if ($errors->has('phone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                        {!! Form::label('description', trans('restaurants.description'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('type_id') ? 'has-error' : ''}}">
                        {!! Form::label('type_id', trans('restaurants.type_id'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::select('type_id', $restaurant_cats, null, ['class' => 'form-control']) !!}
                            {!! $errors->first('type_id', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-inline">
                        <label for="geocode" class="col-md-2 control-label">Geocode</label>    
                        <div class="form-group col-md-3 {{ $errors->has('lat') ? 'has-error' : ''}}">
                            {!! Form::label('lat', trans('restaurants.lat'), ['class' => 'col-md-2 col-md-offset-1 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::number('lat', null, ['class' => 'form-control','step'=>'any']) !!}
                                {!! $errors->first('lat', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group col-md-3 {{ $errors->has('lng') ? 'has-error' : ''}}">
                            {!! Form::label('lng', trans('restaurants.lng'), ['class' => 'col-md-2 col-md-offset-1 control-label']) !!}
                            <div class="col-md-9">
                                {!! Form::number('lng', null, ['class' => 'form-control','step'=>'any']) !!}
                                {!! $errors->first('lng', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="form-group">                                                                                                    
                        <div class="col-md-6 col-md-offset-2">                                            
                            <div style="height: 250px; margin-top: 5px;">                                                    
                                <div id="map"></div>
                            </div>                                                                                       
                        </div>                                                                               
                    </div>
                    <div class="form-group {{ $errors->has('address') ? 'has-error' : ''}}">
                        {!! Form::label('address', trans('restaurants.address'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('address', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('address', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <!--<div class="form-group {{ $errors->has('geocode') ? ' has-error' : '' }}" >                                        
                            <label for="geocode" class="col-md-2 control-label"></label>                                        
                            <div class="col-md-6">
                                <div id="location_geocode" class="input-group">
                                    <input id="location_search" class="form-control" type="textbox" name="location_search" value="{{ old('location_search') }}">
                                    <div class="input-group-btn">                                                                                                              
                                    <button id="submit" type="button" class="btn btn-primary" value="Geocode"><i class="glyphicon glyphicon-map-marker"></i></button>
                                    </div>                                     
                                </div>
                                @if ($errors->has('geocode'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('geocode') }}</strong>
                                    </span>
                                @endif  
                            </div>                                                                               
                    </div>-->
                    <div class="form-group {{ $errors->has('currency') ? 'has-error' : ''}}">
                        {!! Form::label('currency', trans('settings.currency'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">                            
                            {!! Form::select('currency', currency()->all() , null, ['id'=>'currency','class' => 'select2']) !!}
                            {!! $errors->first('currency', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>        
                    @if(auth()->user()->hasRoleLevel([9,12]))
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
                            {!! Form::number('legal_effectif_min', 0, ['class' => 'form-control']) !!}
                            {!! $errors->first('legal_effectif_min', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                     <div class="form-group {{ $errors->has('legal_effectif_max') ? 'has-error' : ''}}">
                        {!! Form::label('legal_effectif_max', trans('restaurants.legal_effectif_max'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::number('legal_effectif_max', 0, ['class' => 'form-control']) !!}
                            {!! $errors->first('legal_effectif_max', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
                        {!! Form::label('status', trans('restaurants.status'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::select('status', ['active' => 'Active', 'inactive' => 'Disable'],null, ['class' => 'form-control']) !!}                       
                            {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>               
                    <div class="form-group {{ $errors->has('verify_status') ? 'has-error' : ''}}">
                        {!! Form::label('status', trans('restaurants.verify_status'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::select('verify_status',['pending' => 'Pending', 'verified' => 'Verified','closed'=>'Closed'], null, ['class' => 'form-control']) !!}
                            {!! $errors->first('verify_status', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>    
                    @endif
                </div>
                <div class="box-footer">
                    <div class="col-md-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> {{trans("restaurants.Create")}}</button>
                        @if(auth()->user()->role_level >= 9)
                        <a href="{{ url('/admin/restaurants') }}" class="btn btn-default"><i class="fa fa-reply" aria-hidden="true"></i> {{trans("restaurants.Cancel")}}</a>                       
                        @endif
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>

@endsection
@section('footer_js')

<!-- The paths might be changed to suit with your folder structure -->
<link rel="stylesheet" href="/intl-tel-input/css/intlTelInput.css" />
<script src="/intl-tel-input/js/intlTelInput.js"></script>
<!--<script src="/js/map-search-location.js"></script>  -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsnpreE3XP96gzuyZd4wmyw2kQ_3zJ3v0&libraries=places"></script>  
<link rel="stylesheet" href="/select2/css/select2.css" />
<script type="text/javascript" src='/select2/js/select2.js'></script>  
<script src="/js/jquery-validation/dist/jquery.validate.js"></script>
<style>
    #map {
    height: 100%;
    width: 100%;
    }
    .intl-tel-input{
        width: 100%;
    }
    .has-error {
        color: #a94442;
    }
    .select2-container .select2-selection--single{height: 100%;}
</style>
<script type="text/javascript">
    $( document ).ready(function() {
        $('#force_add').on('click',function(){
            $('#force_option').val('yes');
            $('#frm_item_add').submit();
        })
         $('#merge_data').on('click',function(){
           // $('#frm_item_add').attr('action','/admin/restaurant/update/'+$("#mer_id").val());
           // $('#frm_item_add').submit();
        })
        $('#phone').intlTelInput({
                utilsScript: '/intl-tel-input/js/utils.js',
                formatOnDisplay: false,
               // separateDialCode:true,
                preferredCountries: ['fr', 'us', 'vn']
        }); 
        $('#phone').on('blur keyup change',function(){
            if($(this).val() != ''){
                var ntlNumber = $("#phone").intlTelInput("getNumber", intlTelInputUtils.numberFormat.E164);              
                    $("#phone").val(ntlNumber);
            }
        });
        $("#currency").prepend('<option value="" selected>Select currency</option>').select2({
            //placeholder: "Select currency",
            //allowClear: true, 
        });
        jQuery.validator.addMethod("phone", function(value, element) {
            var  re = new RegExp(/^[- +()]*[0-9][- +()0-9]*$/);
            return value === '' || $(element).intlTelInput('isValidNumber') || re.test(value);
        }, "Phone is not valid.");
        
        jQuery.validator.addMethod("dial_code_phone", function(value, element) { 
            var countryObj = $(element).intlTelInput("getSelectedCountryData");
            return value === '' || !jQuery.isEmptyObject(countryObj);;
        }, "Please choose country flag!");
        
        $("#frm_item_adds").validate({
            wrapper: "span",
            errorElement: "strong",
            errorClass: "has-error",
            highlight: function(element, errorClass) {
                $(element).parent().parent().addClass(errorClass);
            },
            unhighlight: function(element, errorClass, validClass) {
                 $(element).parent().parent().removeClass(errorClass);
            },
            errorPlacement: function(error, element) {
                var name = $(element).attr('name');
                if(name === 'phone'){
                    error.appendTo( element.parent().parent());
                }else{
                    error.appendTo( element.parent());
                }
            }, 
            invalidHandler: function() {
                $('.alert').remove();
                $( "#form_error_mess" ).html('<div class="alert alert-danger">Form invalid! Please try again.</div>');
            },
            rules: {                   
                    phone:{
                        required: true,
                        dial_code_phone:true,
                        phone: true,
                        maxlength:20
                    },
                    name:{
                        required: true,
                        maxlength:191
                    },
                    address:{
                        required: true,
                        maxlength:191
                    },
                    lat:{
                        required: true,                        
                    },
                    lng:{
                        required: true,                       
                    },
                },
            messages: {
                    name:{
                        required: 'Name is required.',
                        maxlength:'Maxlength is 191 characters'
                    },                   
                    address:{
                        required: 'Restuarant address is required.',                     
                    },
                    phone:{
                        required: 'Phone is required.',                      
                    },
                    lat:{
                        required: 'Latitude is required.',                        
                    },
                    lng:{
                        required: 'Longitude is required.',                       
                    },
                },
        });  
        initMap(); 
    });
    var marker;
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 17,
          center: {lat: 48.856614, lng: 2.35222190000002}
        });
        var geocoder = new google.maps.Geocoder();
        
        $("#address").on('change',function(){
            geocodeAddress(geocoder, map);
        });
        /*document.getElementById('submit').addEventListener('click', function() {
          geocodeAddress(geocoder, map);
        });*/
    }

    function geocodeAddress(geocoder, resultsMap) {
      //var address = document.getElementById('location_search').value;
      var address = document.getElementById('address').value;
      geocoder.geocode({'address': address}, function(results, status) {
        if (status === 'OK') {
            resultsMap.setCenter(results[0].geometry.location);
            if (marker) marker.setMap(null);
            marker = new google.maps.Marker({
              map: resultsMap,
              draggable: true,
              animation: google.maps.Animation.DROP,
              position: results[0].geometry.location
            });
            //marker.addListener('click', toggleBounce);
              marker.addListener('dragend', tryGetLatLng);
            //var address = place.formatted_address;
              var res_latitude = results[0].geometry.location.lat();
              var res_longitude = results[0].geometry.location.lng(); 
              $("#lat").val(res_latitude);
              $("#lng").val(res_longitude);
              if($("#address").val() == ''){
                  var address = results[0].formatted_address;
                  $("#address").val(address);   
              }
              
              /* update currency**/
              //var country = getCountry(results[0].address_components);
              
            } else {
              alert('Geocode was not successful for the following reason: ' + status);
            }
      });
    }
    function getCountry(add_compo){
        var country = '';        
        $.each(add_compo, function( index, value ) {
            $.each(value['types'], function( ind, val ) {
                if(val == 'country'){
                    country = value['short_name'];                    
                    setCurrency(country);
                }
            });
        });
        
        return country;
    }
    function setCurrency(country){
        $.ajax({
            method: "GET",
            url: "/admin/ajax/get-currency/"+country, 
            })
            .done(function( data ) {                
                if(data.status == 'ok'){
                    $('#currency ').val(data.data).trigger('change');
                }              
            });
         
    }
    function toggleBounce() {
        if (marker.getAnimation() !== null) {
          marker.setAnimation(null);         
        } else {
          marker.setAnimation(google.maps.Animation.BOUNCE);          
        }
    }
     function tryGetLatLng() {
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({ 'latLng': marker.getPosition() }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                var res_latitude = marker.getPosition().lat();
                var res_longitude = marker.getPosition().lng();
                $("#lat").val(res_latitude);
                $("#lng").val(res_longitude);
                              
                if($("#address").val() == ''){
                    var address = results[0].formatted_address;
                    $("#address").val(address);   
                }  
                /* update currency**/
                var country = getCountry(results[0].address_components);
            } else {
              alert('Address was not successful for the following reason: ' + status);
            }
        });        
        
    }
</script>
@endsection
