@extends('layouts.admin')

@section('header_css')
<link href="{{asset('assets/plugins/dataTables/dataTables.bootstrap.css')}}" rel="stylesheet" />
@endsection

@section('sidebar')
@include('layouts.partials.admin.main_sidebar')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h2> Dish management </h2>       
    </div>
</div>
        <hr />
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">
                    Dish list
                     <div class="pull-right">
                        <a href="{{route('dish_add')}}"class="btn btn-info">Add Dish</a>
                    </div>
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
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="food_table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>               
                                    <th>Status</th>               
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($foods as $food)
                                 <tr>
                                    <td @if($order_by == 'id') class="active" @endif>{{ $food->id }}</td>
                                    <td @if($order_by == 'name') class="active" @endif>{{ $food->name }}</td>                                    
                                    <td @if($order_by == 'description') class="active" @endif>{{ $food->desciption }}</td>
                                    <td>
                                        <?php $status_class = ['active'=>'label-success','inactive'=>'label-warning','deleted'=>'label-danger'];?>
                                        <span class="label {{$status_class[$food->status]}}">{{title_case($food->status)}}</span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{route('dish_edit',['id'=>$food->id])}}" class="btn btn-info" > Edit </a>
                                        {!! Form::open([
                                            'method'=>'DELETE',
                                            'url' => ['admin/dish/delete', $food->id],
                                            'style' => 'display:inline'
                                            ]) !!}
                                            {!! Form::button('<i class="fa fa-remove"></i>', array(
                                                    'type' => 'submit',
                                                    'class' => 'btn btn-danger',
                                                    'title' => trans('items.Delete'). ' Dish',
                                                    'onclick'=>'return confirm("'.trans('dishes.Confirm delete?').'")'
                                            ));!!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                                @endforeach                                                               
                            </tbody>
                        </table>
                         <div class="text-center">
                            {!! $foods->links() !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>              
   

@endsection
@section('footer_js')
<script src="../assets/plugins/dataTables/jquery.dataTables.js"></script>
<script src="../assets/plugins/dataTables/dataTables.bootstrap.js"></script>
 <script>
     $(document).ready(function () {
         //$('#dataTables-example').dataTable();
     });
</script>
@endsection