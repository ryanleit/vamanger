@extends('layouts.admin')
@section('header_css')

@endsection
@section('content')
<section class="content-header">
    <h1>
        General Form Elements
        <small>Preview</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="/admin/users">Users</a></li>
        <li class="active">Edit</li>
    </ol>
</section>
<section class="content">
  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title">{{trans('roles.Create New')}} Role</h3>
    </div>
    <div class="box-body">
      @if ($errors->any())
          <ul class="alert alert-danger">
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      @endif
      {!! Form::open(['url' => '/admin/roles', 'class' => 'form-horizontal']) !!}
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                {!! Form::label('name', trans('roles.name'), ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-10">
                    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                {!! Form::label('description', trans('roles.description'), ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-10">
                    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            
            <div class="form-group {{ $errors->has('permissions') ? 'has-error' : ''}}">
                {!! Form::label('permissions', trans('roles.permissions'), ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-10">                    
                    @foreach ($components as $component)
                    
                     <div class="panel panel-info">
                        <div class="panel-heading">{{$component['title']}}</div>
                        <div class="panel-body">
                            <div class="form-group">
                            <div class="col-md-12">
                            @foreach ($component['permissions'] as $permission)
                            <label class="checkbox-inline"><input type="checkbox" name="permissions[]" value="{{$permission['id']}}" @if (!empty(old('permissions')) && in_array($permission['id'],old(['permissions']))) {{'checked'}} @endif />{{$permission['title']}}</label>
                            @endforeach
                            </div>
                        </div>   
                        </div>                    
                    </div>
                    @endforeach

                    <!--{!! Form::textarea('permissions', null, ['class' => 'form-control', 'required' => 'required']) !!}-->
                    {!! $errors->first('permissions', '<p class="help-block">:message</p>') !!}
                </div>                              
            </div>
            <div class="form-group {{ $errors->has('status') ? 'has-error' : ''}}">
                {!! Form::label('status', trans('roles.status'), ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-10">                                      
                    {!! Form::text('status', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('status', '<p class="help-block">:message</p>') !!}
                </div>
            </div>
            <div class="form-group {{ $errors->has('role_level') ? 'has-error' : ''}}">
                {!! Form::label('role_level', trans('roles.role_level'), ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-10">
                    {!! Form::number('role_level', null, ['class' => 'form-control', 'required' => 'required']) !!}
                    {!! $errors->first('role_level', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

        <div class="form-group">
            <div class="col-md-offset-2 col-sm-10">
                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> {{trans("roles.Create")}}</button>
                <a href="{{ url('/admin/roles') }}" class="btn btn-default"><i class="fa fa-reply" aria-hidden="true"></i> {{trans("roles.Cancel")}}</a>
            </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>
</section>
@endsection
