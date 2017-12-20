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
      <h3 class="box-title">{{trans('components.Components')}}</h3>
      <div class="box-tools">
        <a href="{{ url('/admin/components/create') }}" class="btn btn-success btn-sm" title="Add New Component"><span class="glyphicon glyphicon-plus" aria-hidden="true"/></a>
      </div>
    </div>

    @if(count($components))
    <div class="box-body">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
              <th style="min-width: 120px;">
                #
                <div class="btn-group pull-right">
                  <a href="{{url('/admin/components?order_by=id&order_direct=desc')}}" class="btn btn-default btn-xs @if($order_by=='id' and $order_direct=='desc') disabled @endif"><i class="fa fa-caret-up"></i></a>
                  <a href="{{url('/admin/components?order_by=id&order_direct=asc')}}" class="btn btn-default btn-xs @if($order_by=='id' and $order_direct=='asc') disabled @endif"><i class="fa fa-caret-down"></i></a>
                </div>
              </th>
              <th> {{ trans('components.title') }}
              <div class="btn-group pull-right">
                <a href="{{url('/admin/components?order_by=title&order_direct=desc')}}" class="btn btn-default btn-xs @if($order_by=='title' and $order_direct=='desc') disabled @endif"><i class="fa fa-caret-up"></i></a>
                <a href="{{url('/admin/components?order_by=title&order_direct=asc')}}" class="btn btn-default btn-xs @if($order_by=='title' and $order_direct=='asc') disabled @endif"><i class="fa fa-caret-down"></i></a>
              </div>
            </th>
              <th class="text-right" style="min-width: 150px;">{{trans('components.Actions')}}</th>
          </tr>
        </thead>
        <tbody>

        @foreach($components as $item)
            <tr>
                <td @if($order_by == 'id') class="active" @endif>{{ $item->id }}</td>
                <td @if($order_by == 'title') class="active" @endif>{{ $item->title }}</td>
                <td class="text-right">
                  <div class="btn-group">
                    <a href="{{ url('/admin/components/' . $item->id) }}" class="btn btn-info btn-sm" title="{{trans('components.View')}} Component"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> {{trans('components.View')}}</a>
                    <button type="button" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                    <ul class="dropdown-menu dropdown-menu-right">
                      <li><a href="{{ url('/admin/components/' . $item->id . '/edit') }}" title="Edit Component"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> {{trans('components.Edit')}}</a></li>
                      <li>
                        {!! Form::open([
                            'method'=>'DELETE',
                            'url' => ['/admin/components', $item->id],
                            'style' => 'display:none'
                        ]) !!}
                            {!! Form::button('<span class="glyphicon glyphicon-trash" aria-hidden="true" title="Delete Component" />', array(
                                    'type' => 'submit',
                                    'class' => '',
                            ));!!}
                        {!! Form::close() !!}
                        <a href="#" onclick="if(confirm('{{trans('components.Confirm delete?')}}')) $(this).parent().find('form').submit(); else return false;"><span class="glyphicon glyphicon-trash" aria-hidden="true" title="{{trans('components.Delete')}} Component"></span> {{trans('components.Delete')}}</a>
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
          <h4>{{trans('components.Empty')}}</h4>
          <p>{{trans('components.This section is empty')}}</p>
        </div>
      </div>
    @endif
    <div class="box-footer clearfix">
      {!! $components->render() !!}
    </div>
  </div>
</section>
@endsection
