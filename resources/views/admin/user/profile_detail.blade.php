@extends('layouts.admin')
@section('header_css')

@endsection
@section('content')
<section class="content-header">

    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <!--<li><a href="/admin/users">Users</a></li>-->
        <li class="active">Detail</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Detail User</h3>                  
                </div>                  
                <div class="box-body">               
                   @if (session()->has('success_message'))
                        <div class="alert alert-success">
                            {{ session()->get('success_message') }}
                        </div>
                    @endif
                    @if (session()->has('fail_message'))
                        <div class="alert alert-danger">
                            {{ session()->get('fail_message') }}
                        </div>
                    @endif
                     <div id="av-preview" class="col-md-4">
                        <div class="img-thumbnail">
                                @if(empty($user->avatar))
                                <img src="{{asset('/images/users/default_avatar.png')}}">
                                @else
                                <img src="{{asset('storage/images/users/'.$user->avatar)}}">
                                @endif
                        </div>                                
                    </div>
                    <div class="col-md-6">                        
                        <div class="col-md-12">
                            <label class="control-label col-md-2">Name</label>
                            <div class="col-md-8">{{$user->name}}</div>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label col-md-2">Email</label>
                            <div class="col-md-8">{{$user->email}}</div>
                        </div>
                        <div class="col-md-12">
                            <label class="control-label col-md-2">Phone</label>
                            <div class="col-md-8">{{$user->phone}}</div>
                        </div>                        
                         <div class="col-md-12">
                            <label class="control-label col-md-2">Timezone</label>
                            <div class="col-md-8">{{$user->timezone}}</div>
                        </div> 
                        <div class="col-md-12">
                            <label class="control-label col-md-2"></label>
                            <div class="col-md-8"><a href="{{ url('/admin/profile') }}" class="btn btn-primary"><i class="fa fa-reply" aria-hidden="true"></i> Edit</a></div>
                        </div>
                    </div>                     
            </div>
        </div>
    </div>
</section>
<!-- Begin Map box -->


<!-- End Map box -->
@endsection
@section('footer_js')
<style>
    #av-preview img{
         width:200px;
         height:200px;
    }
</style>
<script src="/assets/plugins/switch/static/js/bootstrap-switch.min.js"></script>

@endsection        
