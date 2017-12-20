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
    <link href="{{ asset('css/loader.css') }}" rel="stylesheet">
    <link href="{{ asset('css/my-style.css') }}" rel="stylesheet">    
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
    <script src="{{ asset('js/google_latlng.js') }}"></script>
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
                    
                </div>
                @handheld
                <!--<div class="row">
                    <div class="col-sm-12" style="padding:20px;background: #b3ecff;">
                        <div class="col-sm-6">                        
                                <div class="input-group">
                                    <input class="form-control" id="search_location" name="search_location" placeholder="Search location">                               
                                    <div class="input-group-btn">                                                                                                              
                                        <button class="btn btn-default" type="button" id="get_current_latlng"><i class="glyphicon glyphicon-map-marker"></i></button>
                                    </div>                                    
                                </div> 
                        </div>
                        <div class="col-sm-1 text-center">
                            <div class="form-group">
                                <strong>{{ __('navbar.or') }}</strong>
                            </div> 
                        </div>
                        <div class="col-sm-2 text-center">
                            <div class="form-group">
                                <button class="btn btn-primary" id="refresh_location"><span class="glyphicon glyphicon-refresh"></span>{{ __('navbar.location') }}</button>
                            </div> 
                        </div>
                    </div>
                </div>    -->                
                 @endhandheld
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                         <li><a href="/">{{ __('navbar.home') }}</a></li>
                         <li @if($page == 'features') class="active" @endif><a href="/features">{{ __('navbar.features') }}</a></li>
                         <li @if($page == 'aboutus') class="active" @endif><a href="/about-us">{{ __('navbar.about') }}</a></li>
                    </ul>
                      
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        @desktop
                       <!-- <li> 
                            <div class="navbar-form">                                                           
                                <div class="input-group">                               
                                <input class="form-control" id="search_location" name="search_location" placeholder="Search location">                               
                                <div class="input-group-btn">                                                                                                              
                                    <button class="btn btn-default" type="button" id="get_current_latlng"><i class="glyphicon glyphicon-map-marker"></i></button>
                                </div> 
                                </div>                                                                                                                
                            </div>                                                                   
                        </li>-->
                        @enddesktop
                        <!--<li>
                        <div class="">
                               <form id="frm-search" name="restaurant_search" class="navbar-form" role="search" method="POST" action="{{route('restaurant_search')}}">
                                <div class="input-group">
                                    {{ csrf_field() }}
                                   <input type="text" id="search_field" class="form-control" placeholder="Restaurants, dish ..." name="q" value="{{request('q')}}">
                                   <div class="input-group-btn">                                                                       
                                       <input type="hidden" id="latlng" name="latlng" value="{{request()->cookie('latlng')}}" >
                                       <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                   </div>                            
                                </div>                        
                               </form>
                           </div>  
                        </li>
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
                        </li>         -->                              
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">{{ __('auth.login') }}</a></li>
                            <li><a href="{{ route('register') }}">{{ __('auth.register') }}</a></li>                            
                        @else
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
                            
                        @endif                            
                    </ul>                                       
                </div>
            </div>
        </nav>      
        @yield('content')
        <footer>
        
            <nav class="navbar navbar-default navbar-static-top">

                    <div class="container text-center">                                       
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="nav nav-pills nav-justified">
                                    <li><a class="text-danger" href="/">© 2017 Vamanger v1.0.</a></li>
                                    <li><a href="/pro">{{ __('navbar.become_partner')}}</a></li>   
                                    <li><a href="{{route('termservice')}}">{{ __('navbar.terms_service')}}</a></li>
                                    <li><a href="{{route('privacy')}}">{{ __('navbar.privacy')}}</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>         
                </nav>
              <!-- PAGE LEVEL SCRIPTS -->
            @yield('footer_js')
            <!-- END PAGE LEVEL SCRIPTS -->    

            </footer>
    </div>         
</body>
</html>
