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
      <h3 class="box-title">{{trans('components.Components')}} #{{ $component->id }}</h3>
      <div class="box-tools">
        <a href="{{ url('admin/components/' . $component->id . '/edit') }}" class="btn btn-default btn-sm" title="Edit Component"><span class="glyphicon glyphicon-pencil" aria-hidden="true"/></a>
        {!! Form::open([
            'method'=>'DELETE',
            'url' => ['admin/components', $component->id],
            'style' => 'display:inline'
        ]) !!}
            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true"/>', array(
                    'type' => 'submit',
                    'class' => 'btn btn-danger btn-sm',
                    'title' => trans('components.Delete'). ' Component',
                    'onclick'=>'return confirm("'.trans('components.Confirm delete?').'")'
            ));!!}
        {!! Form::close() !!}
      </div>
    </div>
    <div class="box-body table-responsive no-padding">
      <table class="table table-hover">
        <tbody>
            <tr>
                <th>ID</th><td>{{ $component->id }}</td>
            </tr>
            <tr><th> {{ trans('components.title') }} </th><td> {{ $component->title }} </td></tr>
        </tbody>
      </table>
    </div>
    <div class="box-footer clearfix">
      <a href="{{ url('/admin/components') }}" class="btn btn-default"><i class="fa fa-reply" aria-hidden="true"></i> {{trans("components.Back")}}</a>
    </div>
  </div>
</section>

@endsection
