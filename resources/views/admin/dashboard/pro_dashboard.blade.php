@extends('layouts.admin')

@section('content')
<section class="content-header">
    <h1>
        Dashboard
        <small>List</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>      
    </ol>
</section>
<section class="content">
<!-- SELECT2 EXAMPLE -->
<div class="row">
    <div class="col-md-12">
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
    </div>
</div>
<div class="row">     
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-eye-slash"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Total view</span>
              <span class="info-box-number">{{$total_view}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-cutlery"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Dish count</span>
              <span class="info-box-number">{{$menu_count}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-cutlery"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Dish today</span>
              <span class="info-box-number">
                  @if($dish_today_count > 0)
                  {{$dish_today_count}}
                  @else
                  <a href="{{route('my_restaurant_list')}}" class="link">Add dish today</a>
                  @endif
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
<!-- /.box -->
<!-- /.row -->
</section>
@endsection
@section('footer_js')
@endsection