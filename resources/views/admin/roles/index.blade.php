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
      <h3 class="box-title">{{trans('roles.Roles')}}</h3>
      <div class="box-tools">
        <a href="{{ url('/admin/roles/create') }}" class="btn btn-success btn-sm" title="Add New Role"><span class="glyphicon glyphicon-plus" aria-hidden="true"/></a>
      </div>
    </div>

    @if(count($roles))
    <div class="box-body">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
              <th style="min-width: 120px;">
                #
                <div class="btn-group pull-right">
                  <a href="{{url('/admin/roles?order_by=id&order_direct=desc')}}" class="btn btn-default btn-xs @if($order_by=='id' and $order_direct=='desc') disabled @endif"><i class="fa fa-caret-up"></i></a>
                  <a href="{{url('/admin/roles?order_by=id&order_direct=asc')}}" class="btn btn-default btn-xs @if($order_by=='id' and $order_direct=='asc') disabled @endif"><i class="fa fa-caret-down"></i></a>
                </div>
              </th>
              <th> {{ trans('roles.name') }}
              <div class="btn-group pull-right">
                <a href="{{url('/admin/roles?order_by=name&order_direct=desc')}}" class="btn btn-default btn-xs @if($order_by=='name' and $order_direct=='desc') disabled @endif"><i class="fa fa-caret-up"></i></a>
                <a href="{{url('/admin/roles?order_by=name&order_direct=asc')}}" class="btn btn-default btn-xs @if($order_by=='name' and $order_direct=='asc') disabled @endif"><i class="fa fa-caret-down"></i></a>
              </div>
            </th><th> {{ trans('roles.description') }}
              <div class="btn-group pull-right">
                <a href="{{url('/admin/roles?order_by=description&order_direct=desc')}}" class="btn btn-default btn-xs @if($order_by=='description' and $order_direct=='desc') disabled @endif"><i class="fa fa-caret-up"></i></a>
                <a href="{{url('/admin/roles?order_by=description&order_direct=asc')}}" class="btn btn-default btn-xs @if($order_by=='description' and $order_direct=='asc') disabled @endif"><i class="fa fa-caret-down"></i></a>
              </div>
            </th><th> {{ trans('roles.permissions') }}
              <div class="btn-group pull-right">
                <a href="{{url('/admin/roles?order_by=permissions&order_direct=desc')}}" class="btn btn-default btn-xs @if($order_by=='permissions' and $order_direct=='desc') disabled @endif"><i class="fa fa-caret-up"></i></a>
                <a href="{{url('/admin/roles?order_by=permissions&order_direct=asc')}}" class="btn btn-default btn-xs @if($order_by=='permissions' and $order_direct=='asc') disabled @endif"><i class="fa fa-caret-down"></i></a>
              </div>
            </th>
              <th class="text-right" style="min-width: 150px;">{{trans('roles.Actions')}}</th>
          </tr>
        </thead>
        <tbody>

        @foreach($roles as $item)
            <tr>
                <td @if($order_by == 'id') class="active" @endif>{{ $item->id }}</td>
                <td @if($order_by == 'name') class="active" @endif>{{ $item->name }}</td>
                <td @if($order_by == 'description') class="active" @endif>{{ $item->description }}</td>
                <td @if($order_by == 'permissions') class="active" @endif>
                     <?php $permission_arr = json_decode($item->permissions,true); ?>
                     <div class="pull-left">
                        @foreach($permission_arr as $permission)
                        <div class="pull-left" style="margin: 5px;">
                        <span class="label bg-green" >{{ title_case($permission) }}</span>
                        </div>
                        @endforeach
                    </div>
                </td>
                <td class="text-right">
                  <div class="btn-group">
                    <a href="{{ url('/admin/roles/' . $item->id) }}" class="btn btn-info btn-sm" title="{{trans('roles.View')}} Role"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> {{trans('roles.View')}}</a>
                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                    <ul class="dropdown-menu dropdown-menu-right">
                      <li><a href="{{ url('/admin/roles/' . $item->id . '/edit') }}" title="Edit Role"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> {{trans('roles.Edit')}}</a></li>
                      <li>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['/admin/roles', $item->id],
                            'style' => 'display:none'
                        ]) !!}
                            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete Role" />', array(
                                    'type' => 'submit',
                                    'class' => '',
                            ));!!}
                        {!! Form::close() !!}
                        <a href="#" onclick="if(confirm('{{trans('roles.Confirm delete?')}}')) $(this).parent().find('form').submit(); else return false;"><span class="glyphicon glyphicon-trash" aria-hidden="true" title="{{trans('roles.Delete')}} Role"></span> {{trans('roles.Delete')}}</a>
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
          <h4>{{trans('roles.Empty')}}</h4>
          <p>{{trans('roles.This section is empty')}}</p>
        </div>
      </div>
    @endif
    <div class="box-footer clearfix">
      {!! $roles->render() !!}
    </div>
  </div>
</section>
@endsection
