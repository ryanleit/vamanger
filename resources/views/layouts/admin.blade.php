<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Vamanger Admin</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="/AdminLTE/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  
  <!-- Theme style -->
  <link rel="stylesheet" href="/AdminLTE/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="/AdminLTE/dist/css/skins/_all-skins.min.css">
    <link href="{{ asset('css/loader.css') }}" rel="stylesheet"> 
    @yield('header_css')        
    @yield('header_js') 
    <!-- Scripts -->
    <script type="text/javascript">
       window.Laravel = {!! json_encode([
           'csrfToken' => csrf_token(),
       ]) !!};
   </script>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <!-- HEADER SECTION -->
    @section('header')
        @include('layouts.partials.admin.nav_top')
    @show        
    <!-- END HEADER SECTION -->
  
  <!-- Left side column. contains the logo and sidebar -->
  <!-- MENU SECTION -->
    @section('sidebar')
        @include('layouts.partials.admin.main_sidebar',['id'=>null])
    @show        
    <!--END MENU SECTION -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">    
     @yield('content')    
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Vamanger</b> Admin
    </div>
    <strong>Copyright &copy; 2017 <a href="https://vamanger.com">Studio</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
    @section('header')
        @include('layouts.partials.admin.control_sidebar')
    @show 
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="/AdminLTE/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/AdminLTE/dist/js/demo.js"></script>
<script src="{{ asset('js/jquery-loader.js') }}"></script>
 <!-- PAGE LEVEL SCRIPTS -->
    @yield('footer_js')   
<!-- END PAGE LEVEL SCRIPTS -->
<!-- Page script -->
</body>
</html>

