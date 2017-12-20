<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/jquery-confirm.css') }}" rel="stylesheet">
        <link href="{{ asset('css/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
        <link href="{{ asset('css/languages.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link href="{{ asset('css/my-style.css') }}" rel="stylesheet">    
        <script>
            window.Laravel = {!! json_encode([
                    'csrfToken' => csrf_token(),
            ]) !!}
            ;
        </script>
        <!-- Scripts -->   
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/js.cookie.js') }}"></script>
        <!--<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>-->
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>    
        <script src="{{ asset('js/detectmobilebrowser.js') }}"></script>  
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsnpreE3XP96gzuyZd4wmyw2kQ_3zJ3v0&libraries=places"></script>
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container">
                    <div class="navbar-header">

                        <!-- Collapsed Hamburger -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <!-- Branding Image -->
                        <a class="navbar-brand" href="{{ url('/') }}">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                        @handheld
                        <ul class="nav navbar-nav">
                            <li class="dropdown">                            
                                @if(app()->isLocale('fr'))
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="lang-sm" lang="fr"></span><span class="caret"></span></a> 
                                @else
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="lang-sm" lang="en"></span><span class="caret"></span> </a>
                                @endif

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="/set-locale/en"><span class="lang-sm" lang="en"></span></a></li>
                                    <li><a href="/set-locale/fr"><span class="lang-sm" lang="fr"></span></a></li>
                                </ul>
                            </li>
                        </ul>                    
                        @endhandheld
                    </div>  
                    @desktop
                    <div class="collapse navbar-collapse" id="app-navbar-collapse">                                                                                      
                        <ul class="nav navbar-nav navbar-right">
                            @if( auth()->check())
                            @if(auth()->user()->hasRoleLevel([9,12]))
                            <li><a href="/admin/dashboard" class="link">Admin</a></li>                                 
                            @endif
                            @endif
                            <li class="dropdown">                            
                                @if(app()->isLocale('fr'))
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="lang-sm" lang="fr"></span><span class="caret"></span></a> 
                                @else
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="lang-sm" lang="en"></span><span class="caret"></span> </a>
                                @endif

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="/set-locale/en"><span class="lang-sm" lang="en"></span></a></li>
                                    <li><a href="/set-locale/fr"><span class="lang-sm" lang="fr"></span></a></li>
                                </ul>
                            </li>
                        </ul>                  
                    </div>
                    @enddesktop
                    <div>                
                    </div>
            </nav>      
            <div class="container">
                <div class="row">              
                    <div class="col-md-12">            
                        <div class="row">
                            <!--/stories-->
                            <div class="panel  panel-info">                               
                                <div class="panel-body" style="min-height: 700px;"> 
                                    <div class="col-md-12 margin-bottom" style="margin-top: 50px;">                               
                                        <div class="text-center"><h2><strong><span class="text-primary">{{__('homepage.thankyou')}}</span></strong></h2></div>
                                        <div class="text-center"><h3><strong><span class="text-success">{{__('homepage.mess_add_dish')}}</span></strong></h2></div>               
                                        <div class="text-center"><a href="/" class="link">{{__('homepage.return_home')}}</a></div>               
                                        <div class="text-center"><a href="{{route('dish_quick_add',['place'=>$resto_id])}}" class="link">{{__('homepage.continuous_add')}}</a></div>               
                                    </div>
                                    <div class="col-md-12">
                                        <div class="col-md-4 col-md-offset-4">
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border">Voltre avis</legend>

                                                <div class="col-md-12 text-center"><label class="control-label input-label" for="startTime">Est ce que vous etes satisfait?</label></div>
                                                <div class="col-md-6">
                                                    <a href="#" id="like_quick"><i class="fa fa-thumbs-up fa-2x"></i></a>                                                
                                                </div>
                                                <div class="col-md-6">
                                                    <a class=" pull-right" href="#" id="dislike_quick"><i class="fa fa-thumbs-down fa-2x"></i></a>                                                
                                                </div>

                                            </fieldset>
                                            <!--Modal bootstrap-->
                                            <!-- Trigger the modal with a button -->
                                            <!--<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>-->

                                            <!-- Modal -->
                                            <div id="myModal" class="modal fade" role="dialog">
                                                <div class="modal-dialog">

                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <form name="frm_comment" action="{{route('user_exp_comment')}}" method="POST">
                                                            {{ csrf_field() }}
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title">Feel free for comment?</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <textarea rows="4" name="comment" id="comment" class="form-control" placeholder="Comment..." required=""></textarea>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <input type="hidden" name="user_exp_id" id="user_exp_id">
                                                            <input type="hidden" name="resto_id" value="{{$resto_id}}" >
                                                            <button type="submit" class="btn btn-primary">Save</button>
                                                        </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                            <!-- end Modal-->
                                        </div>

                                        <style>
                                            fieldset.scheduler-border {
                                                border: 1px groove #ddd !important;
                                                padding: 0 1.4em 1.4em 1.4em !important;
                                                margin: 0 0 1.5em 0 !important;
                                                -webkit-box-shadow:  0px 0px 0px 0px #000;
                                                box-shadow:  0px 0px 0px 0px #000;
                                            }
                                        </style>
                                        <script>
                                            $(document).ready(function(){
                                                $('#like_quick').click(function(){
                                                    setCookieServer('yes');
                                                });
                                                 $('#dislike_quick').click(function(){
                                                    setCookieServer('no');
                                                });
                                            });
                                            function setCookieServer(like_val){
                                                $.ajax({
                                                    method: "GET",
                                                    url: "/like/quick",
                                                    data: { like: like_val}
                                                    })
                                                    .done(function( msg ) {
                                                        if(msg.status == 'ok' && msg.data != ''){
                                                            $("#user_exp_id").val(msg.data);
                                                            $("#myModal").modal('show');
                                                        }
                                                    });
                                            }
                                        </script>
                                    </div>
                                    @if( !auth()->check())
                                    <div id="signup_frm" style="display:none">
                                    <!-- Start register form -->
                                    <div class="col-md-12" ><div class="text-center text-info"><h3><strong>Sign up</strong></h3></div></div>
                                        <form class="form-horizontal" id="frm_pro_register" role="form" method="POST" action="{{ route('pro_register_post') }}">
                                        <div class="col-md-12">                                                   

                                            <div class="col-md-6">                    
                                                {{ csrf_field() }}
                                                <!--<div class="text-center text-info"><h4><strong>User Info</strong></h4></div>-->
                                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                                    <label for="name" class="col-md-4 control-label">Name</label>

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
                                                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

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
                                                        <label for="phone" class="col-md-4 control-label">Mobile Phone</label>

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
                                                    <label for="password" class="col-md-4 control-label">Password</label>

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
                                                    <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                                    <div class="col-md-8">
                                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                                    </div>
                                                </div>      
                                                <div class="form-group {{ $errors->has('package') ? ' has-error' : '' }}">
                                                    <label for="packages" class="col-md-4 control-label">Choose package</label>

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
                                                <!-- Restaurant info -->
                                                <div id="restaurant_info" style="display: block">
                                                    <!--<div class="text-center text-info margin-bottom"><h4><strong>Restaurant Info</strong></h4></div>-->
                                                    <input id="as_pro_user" type="hidden" name="as_pro_user" value="1"readonly="readonly">
                                                    <div class="form-group{{ $errors->has('restaurant_name') ? ' has-error' : '' }}">
                                                        <label for="restaurant_name" class="col-md-4 control-label">Restaurant Name</label>

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
                                                        <label for="restaurant_address" class="col-md-4 control-label">Address</label>                                        
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
                                                        <label for="geocode" class="col-md-4 control-label">Geocode</label>                                        
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
                                                        <label for="restaurant_phone" class="col-md-4 control-label">Phone</label>
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
                                                        <input id="terms" type="checkbox" name="terms" value="1"> I have read and agree to the terms of use
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
                                                    Register
                                                </button>                           
                                            </div>
                                            </div>                             
                                            <div class="col-md-6">
                                                <div class="form-group">                                                    
                                                    <label class="label-important col-md-3">Already signup?</label>
                                                    <div class="col-md-4"><a href="/login" class="link"><strong>Signin</strong></a></div>
                                                </div>
                                            </div>
                                        </div>
                                        </form>
                                    
                                    <!-- End form register -->
                                    </div>
                                    @endif
                                    
                                </div>
                            </div>                                                                       
                        </div> 
                        
                    </div>
                </div>
                @if( !auth()->check())
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
                @endif
                <script type="text/javascript">
                    $(document).ready(function(){
                        var thankpage_count = Cookies.get('thankpage_count');
                        
                        if(thankpage_count) thankpage_count = parseInt(thankpage_count) + 1;
                        else thankpage_count = 1;
                        
                        if(thankpage_count >= 10){
                            $("#signup_frm").show();
                            Cookies.remove('thankpage_count', { path: '/' }); 
                        }
                        else{
                            Cookies.set('thankpage_count',thankpage_count, { path: '/' });
                        }
                    });
                </script>
            </div>
            <footer>

                <nav class="navbar navbar-default navbar-static-top">

                    <div class="container text-center">                                       
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <ul class="nav nav-pills nav-justified">
                                    <li><a class="text-danger" href="/">© 2017 Vamanger V1.0.</a></li>                                   
                                </ul>
                            </div>
                        </div>
                    </div>         
                </nav>
                <!-- PAGE LEVEL SCRIPTS -->                  
            </footer>
        </div>         
    </body>
</html>
