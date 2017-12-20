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
      <h3 class="box-title">{{trans('users.Users')}}</h3>
      <div class="box-tools">
        <a href="{{ url('/admin/users/create') }}" class="btn btn-success btn-sm" title="Add New User"><span class="glyphicon glyphicon-plus" aria-hidden="true"/></a>
      </div>
    </div>

    @if(count($users))
    <div class="box-body">
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
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
              <th style="min-width: 120px;">
                #
                <div class="btn-group pull-right">
                  <a href="{{url('/admin/users?order_by=id&order_direct=desc')}}" class="btn btn-default btn-xs @if($order_by=='id' and $order_direct=='desc') disabled @endif"><i class="fa fa-caret-up"></i></a>
                  <a href="{{url('/admin/users?order_by=id&order_direct=asc')}}" class="btn btn-default btn-xs @if($order_by=='id' and $order_direct=='asc') disabled @endif"><i class="fa fa-caret-down"></i></a>
                </div>
              </th>
              <th> {{ trans('users.name') }}
              <div class="btn-group pull-right">
                <a href="{{url('/admin/users?order_by=name&order_direct=desc')}}" class="btn btn-default btn-xs @if($order_by=='name' and $order_direct=='desc') disabled @endif"><i class="fa fa-caret-up"></i></a>
                <a href="{{url('/admin/users?order_by=name&order_direct=asc')}}" class="btn btn-default btn-xs @if($order_by=='name' and $order_direct=='asc') disabled @endif"><i class="fa fa-caret-down"></i></a>
              </div>
            </th><th> {{ trans('users.email') }}
              <div class="btn-group pull-right">
                <a href="{{url('/admin/users?order_by=email&order_direct=desc')}}" class="btn btn-default btn-xs @if($order_by=='email' and $order_direct=='desc') disabled @endif"><i class="fa fa-caret-up"></i></a>
                <a href="{{url('/admin/users?order_by=email&order_direct=asc')}}" class="btn btn-default btn-xs @if($order_by=='email' and $order_direct=='asc') disabled @endif"><i class="fa fa-caret-down"></i></a>
              </div>
            </th>
            <!--<th> {{ trans('users.password') }}
              <div class="btn-group pull-right">
                <a href="{{url('/admin/users?order_by=password&order_direct=desc')}}" class="btn btn-default btn-xs @if($order_by=='password' and $order_direct=='desc') disabled @endif"><i class="fa fa-caret-up"></i></a>
                <a href="{{url('/admin/users?order_by=password&order_direct=asc')}}" class="btn btn-default btn-xs @if($order_by=='password' and $order_direct=='asc') disabled @endif"><i class="fa fa-caret-down"></i></a>
              </div>
            </th>-->
              <th class="text-right" style="min-width: 150px;">{{trans('users.Actions')}}</th>
          </tr>
        </thead>
        <tbody>

        @foreach($users as $user)
            <tr>
                <td @if($order_by == 'id') class="active" @endif>{{ $user->id }}</td>
                <td @if($order_by == 'name') class="active" @endif>{{ $user->name }}</td><td @if($order_by == 'email') class="active" @endif>{{ $user->email }}</td>
                <!--<td @if($order_by == 'password') class="active" @endif>{{ $user->password }}</td>-->
                <td class="text-right">
                  <div class="btn-group">
                      <a href="{{ url('/admin/users/' . $user->id . '/edit') }}" title="Edit User" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> {{trans('users.Edit')}}</a>                    
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                    <ul class="dropdown-menu dropdown-menu-right">
                      <li>
                          <a href="{{ url('/admin/users/' . $user->id) }}" title="{{trans('users.View')}} User"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> {{trans('users.View')}}</a>
                      </li>
                      <li>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => [url('/admin/users',['id'=>$user->id,'type'=>'soft'])],
                            'style' => 'display:none'
                        ]) !!}
                        <input type="hidden" name="del_type" value="1" />
                            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete User" />', array(
                                    'type' => 'submit',
                                    'class' => '',
                            ));!!}
                        {!! Form::close() !!}
                        <a href="#" onclick="if(confirm('{{trans('users.Confirm delete?')}}')) $(this).parent().find('form').submit(); else return false;"><span class="glyphicon glyphicon-trash" aria-hidden="true" title="{{trans('users.Delete')}} User"></span> Soft {{trans('users.Delete')}}</a>
                      </li>
                      <li>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => [url('/admin/users',['id'=>$user->id,'type'=>'force'])],
                            'style' => 'display:none'
                        ]) !!}
                            <input type="hidden" name="del_type" value="2" />
                            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete User" />', array(
                                    'type' => 'submit',
                                    'class' => '',
                            ));!!}
                        {!! Form::close() !!}
                        <a href="#" onclick="if(confirm('Do you want to FORCE this user')) $(this).parent().find('form').submit(); else return false;"><span class="glyphicon glyphicon-trash" aria-hidden="true" title="{{trans('users.Delete')}} User"></span> Force Delete </a>
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
          <h4>{{trans('users.Empty')}}</h4>
          <p>{{trans('users.This section is empty')}}</p>
        </div>
      </div>
    @endif
    <div class="box-footer clearfix">
      {!! $users->render() !!}
    </div>
  </div>
</section>
@endsection
