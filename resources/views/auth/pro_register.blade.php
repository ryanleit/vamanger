@extends('layouts.app_pro')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ __('auth.register_pro') }}</div>
                <div class="panel-body">
                    <div class="row">
                        <form class="form-horizontal" id="frm_pro_register" role="form" method="POST" action="{{ route('pro_register_post') }}">
                        <div class="col-md-12">                                                   
                            
                            <div class="col-md-6">                    
                                {{ csrf_field() }}
                                <div class="text-center text-info"><h4><strong>{{ __('auth.user_info') }}</strong></h4></div>
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">{{ __('auth.name') }}</label>

                                    <div class="col-md-8">
                                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label for="email" class="col-md-4 control-label">{{ __('auth.email_address') }}</label>

                                    <div class="col-md-8">
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" autocomplete="off" required>

                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                    <div>
                                        <label for="phone" class="col-md-4 control-label">{{ __('auth.mobile_phone') }}</label>

                                        <div class="col-md-8">
                                            <input id="phone" type="phone" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="+84902686559">                                        
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
                                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password" class="col-md-4 control-label">{{ __('auth.password') }}</label>

                                    <div class="col-md-8">
                                        <input id="password" type="password" class="form-control" name="password" autocomplete="off" required>

                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="password-confirm" class="col-md-4 control-label">{{ __('auth.confirm_password') }}</label>

                                    <div class="col-md-8">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                    </div>
                                </div>      
                                <div class="form-group {{ $errors->has('package') ? ' has-error' : '' }}">
                                    <label for="packages" class="col-md-4 control-label">{{ __('auth.choose_package') }}</label>

                                    <div class="col-md-8">
                                        <div class="radio">
                                            @foreach($packages as $package)
                                            <label class="radio-inline"><input type="radio" name="package" id="package" value="{{$package->id}}" @if(old('package')== $package->id) {{'checked'}} @endif >{{$package->name}}</label>                                            
                                            @endforeach
                                            <br>
                                             @if ($errors->has('package'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('package') }}</strong>
                                            </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>      
                            </div>
                            <div class="col-md-6">
                                
                                <div class="form-group{{ $errors->has('as_pro_user') ? ' has-error' : '' }}">                             
                                    <div class="col-md-6 col-md-offset-4" style="display: none;">
                                        <div class="checkbox">
                                            <label>
                                                <input id="as_pro_user" type="checkbox" name="as_pro_user" value="1"  checked="checked" readonly="readonly"> {{ __('auth.message_signup_pro') }}
                                            </label>
                                        </div>
                                        @if ($errors->has('as_pro_user'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('as_pro_user') }}</strong>
                                            </span>
                                        @endif                              

                                    </div>
                                </div>
                                <!-- Restaurant info -->
                                <div id="restaurant_info" style="display: block">
                                    <div class="text-center text-info margin-bottom"><h4><strong>{{ __('restaurants.restaurant_info') }}</strong></h4></div>

                                    <div class="form-group{{ $errors->has('restaurant_name') ? ' has-error' : '' }}">
                                        <label for="restaurant_name" class="col-md-4 control-label">{{ __('restaurants.restaurant_name') }}</label>

                                        <div class="col-md-8">
                                            <input id="restaurant_name" type="text" class="form-control" name="restaurant_name" value="{{ old('restaurant_name') }}">

                                            @if ($errors->has('restaurant_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('restaurant_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>  
                                    <div class="form-group{{ $errors->has('restaurant_address') ? ' has-error' : '' }}">
                                        <label for="restaurant_address" class="col-md-4 control-label">{{ __('restaurants.address') }}</label>                                        
                                        <div class="col-md-8">                                            
                                                <input id="restaurant_address" type="text" class="form-control" name="restaurant_address" value="{{ old('restaurant_address') }}" >
                                                <input type="hidden" name="geocode" id="restaurant_latlng" value="{{ old('geocode') }}"/>
                                                @if ($errors->has('restaurant_address'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('restaurant_address') }}</strong>
                                                </span>
                                                @endif                                                 
                                        </div>                                        
                                    </div>
                                    <div class="form-group {{ $errors->has('geocode') ? ' has-error' : '' }}">                                        
                                        <label for="geocode" class="col-md-4 control-label">{{ __('restaurants.geocode') }}</label>                                        
                                        <div class="col-md-8">                                            
                                            <div style="height: 250px;">                                                    
                                                <div id="map"></div>
                                            </div> 
                                            @if ($errors->has('geocode'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('geocode') }}</strong>
                                                </span>
                                            @endif  
                                        </div>                                                                               
                                    </div>
                                                                        
                                    <div class="form-group{{ $errors->has('restaurant_phone') ? ' has-error' : '' }}">
                                        <div>
                                        <label for="restaurant_phone" class="col-md-4 control-label">{{ __('restaurants.phone') }}</label>
                                        <div class="col-md-8">                                            
                                            <input id="restaurant_phone" type="text" class="form-control" name="restaurant_phone" value="{{ old('restaurant_phone') }}" placeholder="+84902686559" title="Phone should be start with plus and dial code. Ex: +84902686559">                                                                                        
                                        </div>
                                        </div>
                                        <div  class="col-md-6 col-md-offset-4">
                                            @if ($errors->has('restaurant_phone'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('restaurant_phone') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-4 col-md-offset-2">
                                <div class="checkbox {{ $errors->has('terms') ? ' has-error' : '' }}">
                                    <label>
                                        <input id="terms" type="checkbox" name="terms" value="1"> {{ __('auth.read_term') }}
                                    </label><br>
                                    @if ($errors->has('terms'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('terms') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div><br>
                        <div class="col-md-12" style="margin-top:10px;">
                            <div class="col-md-2 col-md-offset-2">
                            <div class="form-group">      
                                <div class="label-important"></div>
                                <button type="submit" class="btn btn-primary">                                    
                                    {{ __('auth.register') }}
                                </button>                           
                            </div>
                            </div>                             
                            <div class="col-md-6">
                                <div class="form-group">                                                    
                                    <label class="label-important col-md-3">{{ __('auth.already_signup') }}</label>
                                    <div class="col-md-4"><a href="/login" class="link"><strong>{{ __('auth.signin') }}</strong></a></div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</div>
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
</style>
<!-- The paths might be changed to suit with your folder structure -->
<link rel="stylesheet" href="/intl-tel-input/css/intlTelInput.css" />
<script src="/intl-tel-input/js/intlTelInput.js"></script>
<script src="/js/jquery-validation/dist/jquery.validate.js"></script>
<script type="text/javascript">
    $( document ).ready(function() {
        $('#restaurant_phone').intlTelInput({
                utilsScript: '/intl-tel-input/js/utils.js',
                formatOnDisplay: false,
               // separateDialCode:true,
                preferredCountries: ['fr', 'us', 'vn']
        });
        $('#phone').intlTelInput({
                utilsScript: '/intl-tel-input/js/utils.js',
                formatOnDisplay: false,
               // autoPlaceholder: false,               
                preferredCountries: ['fr', 'us', 'vn']
        });
        $('#phone').on('blur keyup change',function(){
            if($(this).val() != ''){
                var ntlNumber = $("#phone").intlTelInput("getNumber", intlTelInputUtils.numberFormat.E164);              
                    $("#phone").val(ntlNumber);
            }
        });
        $("#restaurant_phone").on("blur keyup change", function() {
             if($(this).val() != ''){
                var ntlNumber = $("#restaurant_phone").intlTelInput("getNumber", intlTelInputUtils.numberFormat.E164);              
                    $("#restaurant_phone").val(ntlNumber);
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
        
        $("#frm_pro_register").validate({
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
                if((name == 'terms') || (name == 'package') || (name == 'phone') || (name == 'restaurant_phone')){
                    error.appendTo( element.parent().parent());
                }else{
                    error.appendTo( element.parent());
                }
            },
            rules: {
                    name: "required",                    
                    email: {
                        required: true,
                        email: true
                    },
                    phone:{
                        dial_code_phone:true,
                        phone: true,
                        maxlength:20
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                    password_confirmation:{
                        equalTo: "#password"
                    },
                    package: "required",                    
                    terms: "required",                    
                    restaurant_name:{
                        required: true,
                        maxlength:191
                    },
                    restaurant_address:{
                        required: true,
                        maxlength:191
                    },
                    restaurant_phone:{
                        required: true,
                        dial_code_phone:true,
                        phone: true,
                        maxlength:20
                    }
                },
            messages: {
                    name:{
                        required: 'Name is required.',
                        maxlength:'Maxlength is 191 characters'
                    },                   
                    email: {
                        required: 'Email is required.',                        
                    },
                    password: {
                        required: 'Password is required.',                       
                    },
                    
                    restaurant_name:{
                        required: 'Restuarant name is required.',                     
                    },
                    restaurant_address:{
                        required: 'Restuarant address is required.',                     
                    },
                    restaurant_phone:{
                        required: 'Phone is required.',                      
                    }
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
        
        $("#restaurant_address").on('change',function(){
            geocodeAddress(geocoder, map);
        });
        /*document.getElementById('submit').addEventListener('click', function() {
          geocodeAddress(geocoder, map);
        });*/
    }

    function geocodeAddress(geocoder, resultsMap) {
      var address = document.getElementById('restaurant_address').value;
      geocoder.geocode({'address': address}, function(results, status) {
        if (status === 'OK') {
          resultsMap.setCenter(results[0].geometry.location);
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

            $("#restaurant_latlng").val(res_latitude+"_"+res_longitude);
            } else {
              alert('Geocode was not successful for the following reason: ' + status);
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

                $("#restaurant_latlng").val(res_latitude+"_"+res_longitude);                
                var address = results[0].formatted_address;
                $("#address").val(address);                
            } else {
              alert('Address was not successful for the following reason: ' + status);
            }
        });        
        
    }
    
</script>
@endsection
