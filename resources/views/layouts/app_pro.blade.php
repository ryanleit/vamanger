<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Vamanger Pro</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-confirm.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="{{ asset('css/my-style.css') }}" rel="stylesheet">   
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
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
        <nav id="custom-bootstrap-menu" class="navbar navbar-pro navbar-static-top">
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
                    <a class="navbar-brand" href="{{ url('/pro') }}">
                        Vamanger Pro
                    </a>
                    
                </div>
                
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                         <li @if($page == 'homepro') class="active" @endif><a href="/pro">{{ __('navbar.home') }}</a></li>
                         <li @if($page == 'features') class="active" @endif><a href="/pro/features">{{ __('navbar.features') }}</a></li>
                         <li @if($page == 'price') class="active" @endif><a href="/pro/price">{{ __('navbar.price') }}</a></li>
                         <li @if($page == 'contact') class="active" @endif><a href="/pro/contact">{{ __('navbar.contact') }}</a></li>
                        @if (Auth::check())                                                  
                         <li><a href="{{route('pro_dashboard')}}">Dashboard</a></li>
                        @endif
                         
                    </ul>     
                     <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right"> 
                       <!-- <ul class="nav navbar-nav navbar-right">
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
                        </ul>-->
                        <!-- Authentication Links -->
                        @if (Auth::guest())                       
                            <li><a href="/pro/register">{{ __('navbar.register_pro') }}</a></li>                       
                            <li><a href="{{ route('login') }}">{{ __('navbar.login') }}</a></li>                                                      
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{route('profile_detail')}}">{{ __('navbar.profile') }}</a>
                                    </li>
                                     @if(auth()->user()->role()->first()->role_level >=9)
                                    <li><a href="{{route('dashboard')}}" >{{ __('navbar.dashboard') }}</a></li>
                                    @else
                                         @if(auth()->user()->role()->first()->role_level == 6)
                                            <li><a href="{{route('pro_dashboard')}}" >{{ __('navbar.dashboard') }}</a></li>
                                         @endif
                                    @endif
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('navbar.logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            
                        @endif                                           
                    </ul>       
                </div>
            </div>
        </nav>
               
        @yield('content')
    </div>  
    <footer>
    <nav class="navbar navbar-default navbar-static-top">
                                                                        
            <div class="container text-center">                                              
            <div class="row">
                <div class="col-lg-12">
                    <ul class="nav nav-pills nav-justified">
                        <li><a class="text-danger" href="/">© 2017 Vamanger v1.0-{{app()->environment()}}.</a></li>
                        <li @if($page == 'api') class="active" @endif><a href="{{route('pro_api')}}">API</a></li> 
                        <li @if($page == 'reseller') class="active" @endif><a href="{{route('pro_reseller')}}">{{ __('navbar.reseller')}}</a></li> 
                        <li @if($page == 'terms') class="active" @endif><a href="{{route('pro_termservice')}}">{{ __('navbar.terms_service')}}</a></li>
                        <li @if($page == 'privacy') class="active" @endif><a href="{{route('pro_privacy')}}">{{ __('navbar.privacy')}}</a></li>
                    </ul>
                </div>
            </div>
            </div>         
    </nav>
      <!-- PAGE LEVEL SCRIPTS -->
    @yield('footer_js')
    <!-- END PAGE LEVEL SCRIPTS -->    
    </footer>
</body>
</html>
