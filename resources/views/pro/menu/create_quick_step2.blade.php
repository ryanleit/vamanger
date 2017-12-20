@extends('layouts.admin')
@section('sidebar')
@include('layouts.partials.admin.main_sidebar',['id'=>null])
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
                {!! Form::open(['url' => route('menu_store_quick_step2'),'id'=>'frm_quickmenu_add', 'class' => 'form-horizontal','method' => 'post']) !!}
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
                   
                    <div class="form-group margin-bottom {{ $errors->has('name') ? 'has-error' : ''}}">
                        <!--{!! Form::label('name', 'Menu name' , ['class' => 'col-md-2 control-label']) !!}-->
                        <div class="col-md-4 col-md-offset-4">
                            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required','placeholder'=>'Plat du jour']) !!}
                            <input type="hidden" name="restaurant_id" value="{{$restaurant['id']}}" > 
                            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group margin-bottom {{ $errors->has('price') ? 'has-error' : ''}}">                        
                        <div class="col-md-4 col-md-offset-4">
                            {!! Form::text('price', null, ['class' => 'form-control','placeholder'=>'Prix']) !!}
                            {!! $errors->first('price', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group">                        
                        <div class="col-md-4 col-md-offset-4">
                            <?php $food_count = count($food_cats);?>
                            @foreach($food_cats as $key=> $food)
                            <label class="checkbox-inline"><input type="checkbox" name="foods[]" value="{{$food->id}}" @if(in_array($food->id,old('foods',[]))){{'checked'}}@endif>{{$food->name}}</label>
                            @if((($key+1)%4) == 0 && ($key+1) < $food_count)
                            </div>
                            <div class="col-md-4 col-md-offset-4">
                            @endif
                            @endforeach                    
                        </div>
                    </div>
                    @if(!empty($restaurant['place_id']))
                    
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                        <div class="col-md-4 col-md-offset-4">
                            <div class="col-md-12 panel panel-primary">
                                <div class="row">
                                    <div class="col-md-10">
                                    <span class="text-bold"> <a href="{{route('restaurant_edit',['id'=>$restaurant['id']])}}" class="text-blue Bold" title="Edit restaurant">{{$restaurant['name']}}</a>  </span>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="pull-right">
                                            @if ($restaurant['distance'] >= 0)
                                                @if ($restaurant['distance'] >= 1)
                                                {{round($restaurant['distance'],2)}}{{' km'}}
                                                @else
                                                {{round(($restaurant['distance'] * 1000),0)}}{{' m'}}
                                                @endif
                                            @endif                                            
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-10">
                                    <span>{{$restaurant['address']}} </span>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <span class="badge" style="background: violet">{{$restaurant['menus_count']}}</span>
                                        @if(!empty($restaurant['id']))
                                        <span class="pull-right">
                                            <a href="{{route('restaurant_edit',['id'=>$restaurant['id']])}}" class="text-blue Bold" title="Edit restaurant">Edit</a>
                                        </span>
                                        @endif
                                    </div>
                                </div>                                      
                                <input type="hidden" name="place_id" value="{{$restaurant['place_id']}}" >                                
                            </div>
                        </div>
                    </div>                                                    
                    @endif
                    
                    @if(empty($restaurant['id']))
                    @if(!empty($restaurant['place_id']))
                    <div class="form-group">                        
                        <div class="col-md-7">
                            <a href="javascript:void(0);"class="text-blue pull-right" id="more_option">Edit Resto Info</a>
                        </div>
                    </div>
                    @endif
                    <div id="more_fields" style="display:{{(empty($restaurant['place_id']) || empty($restaurant['phone']) || (count($errors) > 0))?'block':'none'}};">   
                        <div class="form-group {{ $errors->has('restaurant_name') ? 'has-error' : ''}}">
                                <!--{!! Form::label('restaurant_name', 'Restaurant name', ['class' => 'col-md-2 control-label']) !!}-->
                                <div class="col-md-4 col-md-offset-4">
                                    {!! Form::text('restaurant_name', $restaurant['name'], ['class' => 'form-control', 'required' => 'required','placeholder'=>'Restaurant name']) !!}
                                    {!! $errors->first('restaurant_name', '<p class="help-block">:message</p>') !!}
                                </div>
                        </div>
                        <div class="form-group {{ $errors->has('restaurant_address') ? 'has-error' : ''}}">
                            <!--{!! Form::label('restaurant_address', 'Restaurant address', ['class' => 'col-md-2 control-label']) !!}-->
                            <div class="col-md-4 col-md-offset-4">
                                <div class="input-group">
                                    {!! Form::text('restaurant_address', $restaurant['address'], ['class' => 'form-control', 'required' => 'required','placeholder'=>'Restaurant address']) !!}
                                    <div class="input-group-btn">                                                                                                              
                                    <button class="btn btn-default" type="button" id="get_current_latlng"><i class="glyphicon glyphicon-map-marker"></i></button>
                                    </div> 
                                </div>
                                <input type="hidden" id="google_id" name="google_id" value="{{$restaurant['google_id']}}" >
                                <input type="hidden" id="lat" name="lat" value="{{$restaurant['lat']}}" >
                                <input type="hidden" id="lng" name="lng" value="{{$restaurant['lng']}}" >
                                {!! $errors->first('restaurant_address', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                            <div>
                           <!-- <label for="phone" class="col-md-2 control-label">Phone</label>-->
                            <div class="col-md-4 col-md-offset-4">  
                                {!! Form::text('phone', $restaurant['phone'], ['class' => 'form-control','id'=>'phone','placeholder'=>'+84902686559']) !!}                            
                            </div>
                            </div>
                            <div id="error_phone" class="col-md-6 col-md-offset-4">
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>                           
                        </div>                       
                        <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                            <!--{!! Form::label('description', trans('restaurants.description'), ['class' => 'col-md-2 control-label']) !!}-->
                            <div class="col-md-4 col-md-offset-4">
                                {!! Form::textarea('description', null, ['class' => 'form-control','rows' => 2, 'cols' => 40,'placeholder'=>'Restaurant description']) !!}
                                {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
                            </div>
                        </div>                       
                    </div>            
                </div>
                @endif
                <div class="box-footer">
                    <div class="col-md-offset-4 col-sm-10">
                        <button type="submit" class="btn btn-info"><i class="fa fa-check"></i> {{trans("menus.Create")}}</button>
                        <a href="{{ url('admin/menu/add') }}" class="btn btn-default"><i class="fa fa-reply" aria-hidden="true"></i> {{trans("menus.Cancel")}}</a>
                    </div>
                </div>
                {!! Form::close() !!}
        </div>
    </div>
</section>
@endsection
@section('footer_js')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsnpreE3XP96gzuyZd4wmyw2kQ_3zJ3v0&libraries=places"></script>
<script src="{{ asset('js/js.cookie.js') }}"></script>
<!-- The paths might be changed to suit with your folder structure -->
<link rel="stylesheet" href="/intl-tel-input/css/intlTelInput.css" />
<script src="/intl-tel-input/js/intlTelInput.js"></script>
<script src="/js/jquery-validation/dist/jquery.validate.js"></script>
<script type="text/javascript">
    $( document ).ready(function() {
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
        jQuery.validator.addMethod("phone", function(value, element) {
            var  re = new RegExp(/^[- +()]*[0-9][- +()0-9]*$/);
            return value === '' || $(element).intlTelInput('isValidNumber') || re.test(value);
        }, "Phone is not valid.");
        
        jQuery.validator.addMethod("dial_code_phone", function(value, element) { 
            var countryObj = $(element).intlTelInput("getSelectedCountryData");
            return value === '' || !jQuery.isEmptyObject(countryObj);;
        }, "Please choose country flag!");
        
        $("#frm_quickmenu_add").validate({
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
                    error.appendTo( $("#error_phone"));
                }else{
                    error.appendTo( element.parent());
                }
            },          
            rules: {                   
                    phone:{
                        //required: true,
                        dial_code_phone:true,
                        phone: true,
                        maxlength:20
                    },
                    name:{
                        required: true,
                        maxlength:191
                    },
                    restaurant_name:{
                        required: true,
                        maxlength:191
                    },
                    restaurant_address:{
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
                    lat:{
                        required: 'Latitude is required.',                        
                    },
                    lng:{
                        required: 'Longitude is required.',                       
                    },
                },
        });  
        $("#more_option").on('click',function(){
            if($("#more_fields").is(":visible")){
                $("#more_fields").hide();                
            }else{
                $("#more_fields").show('slow');
            }
        });
        $("#get_current_latlng").on('click',function(e){
            e.preventDefault();
            getNewLatlng();
        });
        var cur_latlng = Cookies.get("latlng"); 
        var latlng_arr = (cur_latlng)?cur_latlng.split('_'):[];
        if(latlng_arr.length === 2){  
            latitude = latlng_arr[0];
            longitude = latlng_arr[1];
            showCurrentAddress(latitude,longitude);
            if($("#lat").val() == ''){
                $("#lat").val(latitude);
            }
            if($("#lng").val() == ''){
                $("#lng").val(longitude);
            }
        }
    });
    function showCurrentAddress(lat,lng){       
        var latlng = new google.maps.LatLng(lat, lng);
        var geocoder = new google.maps.Geocoder();
        //var current_address = '';
        geocoder.geocode({'latLng': latlng}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    var current_address = results[0].formatted_address;                    
                    if($("#restaurant_address").val() == ''){
                        $("#restaurant_address").val(current_address);
                    }
                }
            } else {
                console.log("Geocoder failed due to: " + status);
            }
        });         
    }
     function getNewLatlng(){
        var startPos;
        var geoOptions = {
            maximumAge: 5 * 60 * 1000,
            timeout: 10 * 1000,
            enableHighAccuracy: true
        }
        var geoSuccess = function(position) {
            startPos = position;                                                                    
            setCookieServer(position.coords.latitude,position.coords.longitude);
        };
        var geoError = function(error) {
          console.log('Error occurred. Error code: ' + error.code);
          // error.code can be:
          //   0: unknown error
          //   1: permission denied
          //   2: position unavailable (error response from location provider)
          //   3: timed out
        };

        navigator.geolocation.getCurrentPosition(geoSuccess, geoError, geoOptions);
    }
    function setCookieServer(lat_val,lng_val){
        $.ajax({
            method: "GET",
            url: "/cookie/latlng",
            data: { lat: lat_val, lng: lng_val }
            })
            .done(function( msg ) {
                if(msg.status == 'ok'){
                    //Cookies.set("updatedLatlng",'yes',{expires:1, path: '/' });
                    location.reload();
                }
            });
    }
</script>
@endsection        
