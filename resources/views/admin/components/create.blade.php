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
      <h3 class="box-title">{{trans('components.Create New')}} Component</h3>
    </div>
    <div class="box-body">
      @if ($errors->any())
          <ul class="alert alert-danger">
              @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
              @endforeach
          </ul>
      @endif
      {!! Form::open(['url' => '/admin/components', 'class' => 'form-horizontal']) !!}
                    <div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
                {!! Form::label('title', trans('components.title'), ['class' => 'col-md-2 control-label']) !!}
                <div class="col-md-10">
                    {!! Form::text('title', null, ['class' => 'form-control']) !!}
                    {!! $errors->first('title', '<p class="help-block">:message</p>') !!}
                </div>
            </div>

        <div class="form-group">
            <div class="col-md-offset-2 col-sm-10">
                <button type="submit" class="btn btn-success"><i class="fa fa-check"></i> {{trans("components.Create")}}</button>
                <a href="{{ url('/admin/components') }}" class="btn btn-default"><i class="fa fa-reply" aria-hidden="true"></i> {{trans("components.Cancel")}}</a>
            </div>
        </div>
      {!! Form::close() !!}
    </div>
  </div>
</section>
@endsection
