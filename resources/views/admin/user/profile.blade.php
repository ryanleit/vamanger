@extends('layouts.admin')
@section('header_css')

@endsection
@section('content')
<section class="content-header">
    <ol class="breadcrumb">
        <li><a href="/admin/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <!--<li><a href="/admin/users">Users</a></li>-->
        <li class="active">Edit</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Edit User</h3>                  
                </div>   
                {!! Form::model($user, [
                'method' => 'PATCH',
                'url' => ['/admin/profile'],
                'id'=>'profile-form',
                'enctype'=>'multipart/form-data',
                'name'=>'profile-form',
                'class' => 'form-horizontal'
                ]) !!}
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
                    <style>
                        #av-preview img{
                             width:200px;
                             height:200px;
                        }
                    </style>
                     <div class="form-group">
                         {!! Form::label('name', trans('users.avatar'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            <div  class="col-md-12 margin-bottom "> 
                                 <!-- Current avatar -->
                                 <div class="avatar-view" id="avatar-view" title="Change the avatar">
                                 @if(empty($user->avatar))
                                    <img src="{{asset('images/users/default_avatar.png')}}">
                                    @else
                                    <img src="{{asset('storage/images/users/'.$user->avatar)}}">
                                    @endif  
                                </div>                           
                            </div>                           
                        </div>                            
                    </div>
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                        {!! Form::label('name', trans('users.name'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                            {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>          
                    <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                       {!! Form::label('email', trans('users.email'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('email', null, ['class' => 'form-control']) !!}
                            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('phone') ? 'has-error' : ''}}">
                        {!! Form::label('phone', trans('users.phone'), ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('phone', null, ['class' => 'form-control','placeholder'=>'+84902686559']) !!}
                            {!! $errors->first('phone', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div> 
                    <div class="form-group {{ $errors->has('timezone') ? 'has-error' : ''}}">
                       {!! Form::label('timezone', 'Timezone', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-6">
                            
                                {!! Form::select('timezone', $timezone_list, $user->timezone, ['id'=>'timezone','class' => 'form-control select2']) !!}
                                <!--@foreach ($timezone_list as $key => $timezone)
                                    <option value="{{ $key }}"{{ $key == old('timezone') ? ' selected' : '' }}>{{ $timezone }} - {{$key}}</option>
                                @endforeach-->
                          
                            {!! $errors->first('timezone', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                    
                    <div class="form-group clearfix">                        
                        <div class="col-md-6 col-md-offset-2">   
                             <label class="checkbox-inline"><input type="checkbox" name="del_account" value="yes" />Delete account
                                 <span class="text-danger"> (** if checked you can not login unless register again!**)</span>
                             </label>                          
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="col-md-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> {{trans("users.Update")}}</button>
                        <a href="{{ url('/admin/profile-detail') }}" class="btn btn-default"><i class="fa fa-reply" aria-hidden="true"></i> {{trans("users.Cancel")}}</a>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</section>
<!-- Begin Map box -->

<div class="container" id="crop-avatar">

    <!-- Current avatar -->   

    <!-- Cropping modal -->
    <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <form class="avatar-form" action="/admin/crop" enctype="multipart/form-data" method="post">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" id="avatar-modal-label">Change Avatar</h4>
            </div>
            <div class="modal-body">
              <div class="avatar-body">

                <!-- Upload image and data -->
                <div class="avatar-upload">
                  <input type="hidden" class="avatar-src" name="avatar_src">
                  <input type="hidden" class="avatar-data" name="avatar_data">
                  <label for="avatarInput">Local upload</label>
                  <input type="file" class="avatar-input" id="avatarInput" name="avatar_file">
                </div>

                <!-- Crop and preview -->
                <div class="row">
                  <div class="col-md-9">
                    <div class="avatar-wrapper"></div>
                  </div>
                  <div class="col-md-3">
                    <div class="avatar-preview preview-lg"></div>
                    <div class="avatar-preview preview-md"></div>
                    <div class="avatar-preview preview-sm"></div>
                  </div>
                </div>

                <div class="row avatar-btns">
                  <div class="col-md-9">
                    <div class="btn-group">
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="-90" title="Rotate -90 degrees">Rotate Left</button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="-15">-15deg</button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="-30">-30deg</button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45">-45deg</button>
                    </div>
                    <div class="btn-group">
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="90" title="Rotate 90 degrees">Rotate Right</button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="15">15deg</button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="30">30deg</button>
                      <button type="button" class="btn btn-primary" data-method="rotate" data-option="45">45deg</button>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <button type="submit" class="btn btn-primary btn-block avatar-save">Done</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div> -->
          </form>
        </div>
      </div>
    </div><!-- /.modal -->

    <!-- Loading state -->
    <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
    </div>
<!-- End Map box -->
@endsection
@section('footer_js')
<link rel="stylesheet" href="/intl-tel-input/css/intlTelInput.css" />
<script src="/intl-tel-input/js/intlTelInput.js"></script>
<link rel="stylesheet" href="/select2/css/select2.css" />
<style>.select2-container .select2-selection--single{height: 100%;}</style>
<script type="text/javascript" src='/select2/js/select2.js'></script>  
<script src="/js/jquery-validation/dist/jquery.validate.js"></script>
<link rel="stylesheet" href="/css/cropper.min.css" />
<script type="text/javascript" src='/js/cropper.min.js'></script>  
<link rel="stylesheet" href="/css/main.css" />
<script type="text/javascript" src='/js/main.js'></script>  
<script type="text/javascript" src='/js/profile.js'></script>  
<script type="text/javascript">
    $( document ).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(".select2").select2({
            placeholder: "Select...",
            allowClear: true,          
        });
    });
</script>

@endsection        
