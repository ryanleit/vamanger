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
    <div class="box-header with-border">
      <h3 class="box-title">{{trans('permissions.Permissions')}}</h3>
      <div class="box-tools">
        <a href="{{ url('/admin/permissions/create') }}" class="btn btn-success btn-sm" title="Add New Permission"><span class="glyphicon glyphicon-plus" aria-hidden="true"/></a>
      </div>
    </div>

    @if(count($permissions))
    <div class="box-body">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
              <th style="min-width: 120px;">
                #
                <div class="btn-group pull-right">
                  <a href="{{url('/admin/permissions?order_by=id&order_direct=desc')}}" class="btn btn-default btn-xs @if($order_by=='id' and $order_direct=='desc') disabled @endif"><i class="fa fa-caret-up"></i></a>
                  <a href="{{url('/admin/permissions?order_by=id&order_direct=asc')}}" class="btn btn-default btn-xs @if($order_by=='id' and $order_direct=='asc') disabled @endif"><i class="fa fa-caret-down"></i></a>
                </div>
              </th>
              <th> {{ trans('permissions.title') }}
              <div class="btn-group pull-right">
                <a href="{{url('/admin/permissions?order_by=title&order_direct=desc')}}" class="btn btn-default btn-xs @if($order_by=='title' and $order_direct=='desc') disabled @endif"><i class="fa fa-caret-up"></i></a>
                <a href="{{url('/admin/permissions?order_by=title&order_direct=asc')}}" class="btn btn-default btn-xs @if($order_by=='title' and $order_direct=='asc') disabled @endif"><i class="fa fa-caret-down"></i></a>
              </div>
            </th><th> {{ trans('permissions.component_id') }}
              <div class="btn-group pull-right">
                <a href="{{url('/admin/permissions?order_by=component_id&order_direct=desc')}}" class="btn btn-default btn-xs @if($order_by=='component_id' and $order_direct=='desc') disabled @endif"><i class="fa fa-caret-up"></i></a>
                <a href="{{url('/admin/permissions?order_by=component_id&order_direct=asc')}}" class="btn btn-default btn-xs @if($order_by=='component_id' and $order_direct=='asc') disabled @endif"><i class="fa fa-caret-down"></i></a>
              </div>
            </th>
              <th class="text-right" style="min-width: 150px;">{{trans('permissions.Actions')}}</th>
          </tr>
        </thead>
        <tbody>

        @foreach($permissions as $item)
            <tr>
                <td @if($order_by == 'id') class="active" @endif>{{ $item->id }}</td>
                <td @if($order_by == 'title') class="active" @endif>{{ $item->title }}</td><td @if($order_by == 'component_id') class="active" @endif>{{ $item->component_id }}</td>
                <td class="text-right">
                  <div class="btn-group">
                    <a href="{{ url('/admin/permissions/' . $item->id) }}" class="btn btn-info btn-sm" title="{{trans('permissions.View')}} Permission"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> {{trans('permissions.View')}}</a>
                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                    <ul class="dropdown-menu dropdown-menu-right">
                      <li><a href="{{ url('/admin/permissions/' . $item->id . '/edit') }}" title="Edit Permission"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> {{trans('permissions.Edit')}}</a></li>
                      <li>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['/admin/permissions', $item->id],
                            'style' => 'display:none'
                        ]) !!}
                            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete Permission" />', array(
                                    'type' => 'submit',
                                    'class' => '',
                            ));!!}
                        {!! Form::close() !!}
                        <a href="#" onclick="if(confirm('{{trans('permissions.Confirm delete?')}}')) $(this).parent().find('form').submit(); else return false;"><span class="glyphicon glyphicon-trash" aria-hidden="true" title="{{trans('permissions.Delete')}} Permission"></span> {{trans('permissions.Delete')}}</a>
                      </li>
                    </ul>
                  </div>

                </td>
            </tr>
        @endforeach
        </tbody>
      </table>
    </div>
    @else
      <div class="box-body">
        <div class="callout bg-gray">
          <h4>{{trans('permissions.Empty')}}</h4>
          <p>{{trans('permissions.This section is empty')}}</p>
        </div>
      </div>
    @endif
    <div class="box-footer clearfix">
      {!! $permissions->render() !!}
    </div>
  </div>
</section>
@endsection
