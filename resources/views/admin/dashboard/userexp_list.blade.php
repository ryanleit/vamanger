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
        <h2> Statistic user experiences </h2>       
    </div>
</div>
        <hr />
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div class="box-header">
                    User experiences                    
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
                        <div><span class="text-primary"><strong>Like Count: {{$like_count}}</strong></span></div>
                        <div><span class="text-danger"><strong>DishLike Count: {{$dislike_count}}</strong></span></div>
                        <table class="table table-striped table-bordered table-hover" id="food_table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Page</th>
                                    <th>Username</th>
                                    <th>Like</th>                                     
                                    <th>Comment</th>               
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($userExps as $exp)
                                 <tr>
                                    <td @if($order_by == 'id') class="active" @endif>{{ $exp->id }}</td>
                                    <td @if($order_by == 'page') class="active" @endif>{{ $exp->page }}</td>
                                    <td @if($order_by == 'username') class="active" @endif>{{ $exp->user_name }}</td>                                    
                                    <td @if($order_by == 'like') class="active" @endif>{{ $exp->like }}</td>                                 
                                    <td>
                                        <span>{{$exp->comment}}</span>
                                    </td>
                                    <td class="text-center">                                      
                                        {!! Form::open([
                                            'method'=>'DELETE',
                                            'url' => ['admin/user-exp/delete', $exp->id],
                                            'style' => 'display:inline'
                                            ]) !!}
                                            {!! Form::button('<i class="fa fa-remove"></i>', array(
                                                    'type' => 'submit',
                                                    'class' => 'btn btn-danger',
                                                    'title' => trans('items.Delete'). ' Row',
                                                    'onclick'=>'return confirm("'.trans('dishes.Confirm delete?').'")'
                                            ));!!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                                @endforeach                                                               
                            </tbody>
                        </table>
                         <div class="text-center">
                            {!! $userExps->links() !!}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>              
   

@endsection
@section('footer_js')
<script src="AdminLTE/plugins/dataTables/jquery.dataTables.js"></script>
<script src="AdminLTE/plugins/dataTables/dataTables.bootstrap.js"></script>
 <script>
     $(document).ready(function () {
         //$('#dataTables-example').dataTable();
     });
</script>
@endsection