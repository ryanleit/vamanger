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
     <link href="{{ asset('css/loader.css') }}" rel="stylesheet"> 
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    <!-- Scripts -->   
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/js.cookie.js') }}"></script>
    <script src="{{ asset('js/jquery-loader.js') }}"></script>
    <!--<script src="{{ asset('js/jquery-2.2.3.min.js') }}"></script>-->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>    
    <script src="{{ asset('js/detectmobilebrowser.js') }}"></script>    
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                    @mobile
                    @if( auth()->check())
                        @if(auth()->user()->hasRoleLevel([6,9,12]))
                        <span class="navbar-brand text-primary"><a href="/admin/dashboard" class="link">{{auth()->user()->name}}</a></span>                                 
                        @endif
                    @endif
                    @endmobile
                     <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button> 
                    
                    @mobile                    
                    <!--<ul class="nav navbar-nav navbar-right">                      
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
                    </ul>  -->                  
                    @endmobile
                   
                </div>  
                @notmobile
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                         <li  @if($page == 'home') class="active" @endif><a href="/">{{ __('navbar.home')}}</a></li>
                         <li  @if($page == 'search') class="active" @endif><a href="/">{{ __('navbar.dish')}}</a></li>
                         <li  @if($page == 'resto_nearby') class="active" @endif><a href="/restaurants-nearby">{{ __('navbar.restaurants')}}</a></li>
                         <li  @if($page == 'resto_favor') class="active" @endif><a href="/restaurants-favourite">{{ __('navbar.favourite')}}</a></li>
                         <li  @if($page == 'aboutus') class="active" @endif><a href="/about-us">{{ 'Aboutus'}}</a></li>
                    </ul>                                                   
                    <div class="pull-right" style="margin: 6px;"><a href="{{route('restos_google_list')}}" class="btn btn-primary">{{ __('navbar.publish_dish')}}</a></div>
                    <!--<div class="pull-right" style="margin-top: 14px;">  -->                     
                            <!--<a href="/set-locale/en"><span class="lang-sm" lang="en"></span></a>
                            |
                            <a href="/set-locale/fr"><span class="lang-sm" lang="fr"></span></a>-->
                        <ul class="nav navbar-nav navbar-right">
                            @if( auth()->check())
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{route('profile_detail')}}" >{{ __('auth.profile') }}</a></li>
                                    @if(auth()->user()->role()->first()->role_level >=9)
                                    <li><a href="{{route('dashboard')}}" >Dashboard</a></li>
                                    @else
                                         @if(auth()->user()->role()->first()->role_level == 6)
                                            <li><a href="{{route('pro_dashboard')}}" >{{ __('navbar.dashboard') }}</a></li>
                                         @endif
                                    @endif
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{__('auth.logout')}}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            @else
                                <li><a href="/login" class="text-blue"><strong>Signin</strong></a></li> 
                                
                                <li><a href="/register" class="text-blue"><strong>Signup</strong></a></li> 
                            @endif
                            <!--Not show language flag in this version-->
                            <!--<li class="dropdown">                            
                            @if(app()->isLocale('fr'))
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="lang-sm" lang="fr"></span><span class="caret"></span></a> 
                            @else
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="lang-sm" lang="en"></span><span class="caret"></span> </a>
                            @endif

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="/set-locale/en"><span class="lang-sm" lang="en"></span></a></li>
                                <li><a href="/set-locale/fr"><span class="lang-sm" lang="fr"></span></a></li>
                            </ul>
                            </li>-->
                        </ul>
                   <!-- </div>-->
                </div>
                @endnotmobile
                <div>
                
            </div>
        </nav>      
        @yield('content')
        <footer>
        
            <nav class="navbar navbar-default navbar-static-top">

                    <div class="container text-center">                                       
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="nav nav-pills nav-justified">
                                    <li><a class="text-danger" href="/">© 2017 Vamanger V1.0.</a></li>
                                    <!--<li><a href="/pro">{{ __('navbar.become_partner')}}</a></li> -->  
                                    <li><a href="{{route('termservice')}}">{{ __('navbar.terms_service')}}</a></li>
                                    <li><a href="{{route('privacy')}}">{{ __('navbar.privacy')}}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>         
                </nav>
              <!-- PAGE LEVEL SCRIPTS -->
              <script src="{{ asset('js/js.cookie.js') }}"></script>
            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDsnpreE3XP96gzuyZd4wmyw2kQ_3zJ3v0&libraries=places"></script>
            @yield('footer_js')
            <!-- END PAGE LEVEL SCRIPTS -->    
            <script type="text/javascript">
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
            </script>
            </footer>
    </div>         
</body>
</html>
