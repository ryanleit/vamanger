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
  <div class="box">
    <div class="box-header">
      <h3 class="box-title">{{trans('permissions.Permissions')}} #{{ $permission->id }}</h3>
      <div class="box-tools">
        <a href="{{ url('admin/permissions/' . $permission->id . '/edit') }}" class="btn btn-default btn-sm" title="Edit Permission"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
        {!! Form::open([
            'method'=>'DELETE',
            'url' => ['admin/permissions', $permission->id],
            'style' => 'display:inline'
        ]) !!}
            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
                    'type' => 'submit',
                    'class' => 'btn btn-danger btn-sm',
                    'title' => trans('permissions.Delete'). ' Permission',
                    'onclick'=>'return confirm("'.trans('permissions.Confirm delete?').'")'
            ));!!}
        {!! Form::close() !!}
      </div>
    </div>
    <div class="box-body table-responsive no-padding">
      <table class="table table-hover">
        <tbody>
            <tr>
                <th>ID</th><td>{{ $permission->id }}</td>
            </tr>
            <tr><th> {{ trans('permissions.title') }} </th><td> {{ $permission->title }} </td></tr><tr><th> {{ trans('permissions.component_id') }} </th><td> {{ $permission->component_id }} </td></tr>
        </tbody>
      </table>
    </div>
    <div class="box-footer clearfix">
      <a href="{{ url('/admin/permissions') }}" class="btn btn-default"><i class="fa fa-reply" aria-hidden="true"></i> {{trans("permissions.Back")}}</a>
    </div>
  </div>
</section>

@endsection
