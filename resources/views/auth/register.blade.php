@extends('layouts.app')

@section('content')
<div class="container" style="min-height: 500px;">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default" style="min-height: 500px;">
                <div class="panel-heading">Register</div>
                <div class="panel-body">
                    @if (session()->has('success_message'))
                        <div class="alert alert-success">
                            {!! session()->get('success_message') !!}
                        </div>
                    @endif
                    @if (session()->has('fail_message'))
                        <div class="alert alert-danger">
                            {!! session()->get('fail_message') !!}
                        </div>
                    @endif
                    <div class="row">
                        <form class="form-horizontal" id="frm-register" role="form" method="POST" action="{{ route('register') }}">
                        <div class="col-md-12">                                                   
                            
                            <div class="col-md-8">                    
                                {{ csrf_field() }}
                                <!--div class="text-center text-info"><h4><strong>User Info</strong></h4></div> -->

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
<script src="/js/jquery-validation/dist/jquery.validate.js"></script>
<script type="text/javascript">
$( document ).ready(function() {
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
            error.appendTo( element.parent());
        },
        rules: {
                email: {
                    required: true,
                    email: true
                },                
                password: {
                    required: true,
                    minlength: 6
                },
                terms: "required",
            },
        messages: {                   
                email: {
                    required: 'Email is required.',                        
                },
                password: {
                    required: 'Password is required.',                       
                }
            },
    });        
});
</script>
@endsection
