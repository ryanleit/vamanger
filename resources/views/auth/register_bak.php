@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    <div class="row">
                        <form class="form-horizontal" id="frm-register" role="form" method="POST" action="{{ route('register') }}">
                        <div class="col-md-12">                                                   
                            
                            <div class="col-md-8">                    
                                {{ csrf_field() }}
                                <div class="text-center text-info"><h4><strong>User Info</strong></h4></div>
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name" class="col-md-4 control-label">Name</label>

                                    <div class="col-md-6">
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

                                    <div class="col-md-6">
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

                                        <div class="col-md-6">
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

                                    <div class="col-md-6">
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

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                    </div>
                                </div>                                                                                            
                            </div>
                            <div class="col-md-4">
                                
                                <div class="col-md-4">
                                <div class="form-group">                                                    
                                    <div class="label-important">Already signup?</div>
                                    <div><a href="/login" class="btn btn-primary">Signin</a></div>
                                </div>
                                </div>

                            </div>                                                        
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6 col-md-offset-3">
                            <div class="form-group {{ $errors->has('terms') ? ' has-error' : '' }}">               
                                <div class="checkbox">
                                    <label>
                                        <input id="terms" type="checkbox" name="terms" value="1"> Terms condition
                                    </label><br>
                                    @if ($errors->has('terms'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('terms') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-primary">                                    
                                    Register
                                </button>                           
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
    $('#phone').intlTelInput({
        utilsScript: '/intl-tel-input/js/utils.js',
        formatOnDisplay: false,
       // autoPlaceholder: false,               
        preferredCountries: ['fr', 'us', 'vn']
    });
    $('#phone').on('blur',function(){
        if($(this).val() != ''){
            var ntlNumber = $("#phone").intlTelInput("getNumber", intlTelInputUtils.numberFormat.E164);              
                $("#phone").val(ntlNumber);
        }
    });
    /*$( function() {
        $( document ).tooltip({
          position: {
            my: "center bottom-20",
            at: "center top",
            using: function( position, feedback ) {
              $( this ).css( position );
              $( "<div>" )
                .addClass( "arrow" )
                .addClass( feedback.vertical )
                .addClass( feedback.horizontal )
                .appendTo( this );
            }
          }
        });
    } );*/
    jQuery.validator.addMethod("phone", function(value, element) {
            var  re = new RegExp(/^[- +()]*[0-9][- +()0-9]*$/);
            return value === '' || $(element).intlTelInput('isValidNumber') || re.test(value);
    }, "Phone is not valid.");
    jQuery.validator.addMethod("dial_code_phone", function(value, element) { 
            var countryObj = $(element).intlTelInput("getSelectedCountryData");
            return value === '' || !jQuery.isEmptyObject(countryObj);;
        }, "Please choose country flag!");
    $("#frm-register").validate({
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
            if((name == 'terms') || (name == 'phone') || (name == 'restaurant_phone')){
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
                phone: {
                    dial_code_phone:true,
                    phone:true
                },
                password: {
                    required: true,
                    minlength: 6
                },
                password_confirmation:{
                    equalTo: "#password"
                },
                
                terms: "required",                    
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
            },
    });        
});
</script>
@endsection
