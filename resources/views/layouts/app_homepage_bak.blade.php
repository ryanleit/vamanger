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
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                         <li><a href="/">Home</a></li>
                         <li><a href="/features">Features</a></li>
                         <li><a href="/about-us">About</a></li>
                    </ul>
                      
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">                                             
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>                            
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{route('profile_detail')}}" >Profile</a></li>
                                    @if(auth()->user()->role()->first()->role_level >=9)
                                    <li><a href="{{route('dashboard')}}" >Dashboard</a></li>
                                    @else
                                         @if(auth()->user()->role()->first()->role_level == 6)
                                            <li><a href="{{route('pro_dashboard')}}" >Dashboard</a></li>
                                         @endif
                                    @endif
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
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
                                    <li><a class="text-danger" href="/">© 2017 Vamanger V1.0-{{app()->environment()}}.</a></li>
                                    <li><a href="/pro">Become partner</a></li>   
                                    <li><a href="{{route('termservice')}}">Terms of Service</a></li>
                                    <li><a href="{{route('privacy')}}">Privacy</a></li>
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
