<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
            @if(empty($user->avatar))
            <img src="/images/users/default_avatar.png" class="img-circle" alt="User Image" width="160px" height="160px">
            @else
            <img src="/storage/images/users/{{$user->avatar}}" class="img-circle" alt="User Image" width="160px" height="160px">
            @endif
        </div>
        @if(auth()->check())
        <div class="pull-left info">
          <p>{{auth()->user()->name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
        @endif
      </div>
      <!-- search form -->
      <!--<form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>-->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        
        @if(auth()->user()->hasRoleLevel([9,12]))
        <li class="treeview @if ($active_tab=='dashboard') {{'active'}} @endif ">
          <a href="/admin/dashboard">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>            
          </a>
        </li>
        <li class="treeview @if ($active_tab=='dashboard') {{'active'}} @endif ">
          <a href="/admin/user-exps">
            <i class="fa fa-tasks"></i> <span>Statistic User Experiences</span>            
          </a>
        </li>
        <li class="active"><a href="{{route('profile_detail')}}"><i class="fa fa-user"></i> Profile</a></li>
        <li class="active"><a href="{{route('password_edit')}}"><i class="fa fa-key"></i>Change password</a></li>
        
        <li class="active"><a href="/admin/roles"><i class="fa fa-minus-circle "></i> Roles management</a></li>
        <li class="active"><a href="/admin/permissions"><i class="fa fa-flag"></i> Permissions management</a></li>
        <li class="active"><a href="/admin/components"><i class="fa fa-hand-paper-o"></i> Components management</a></li>
        <li class="treeview @if ($active_tab=='users') {{'active'}} @endif ">
          <a href="/admin/users">
            <i class="fa fa-users"></i> <span>Users</span>            
          </a>
        </li>
       
        <li class="treeview @if ($active_tab=='restaurant') {{'active'}} @endif ">
            <a href="/admin/restaurants">
                <i class="fa fa-tasks"></i> <span>Restaurants List</span> 
            </a>
        </li> 
        <li class="treeview @if ($active_tab=='dish') {{'active'}} @endif ">
            <a href="/admin/dishes">
                <i class="fa fa-cutlery"></i> <span>Categories</span> 
            </a>
        </li> 
        <li class="active"><a href="{{route('menu_add_quick')}}"><i class="fa fa-edit"></i>Menu add quick</a></li>
        <li class="active">
            <a href="#"><i class="fa fa-clock-o"></i>Time: <span class="text-danger">
                <?php echo date('Y-m-d H:i:s',time());?>
                (<?php echo date_default_timezone_get();?>)
            </span></a>
        </li>
        @else
           @if(auth()->user()->hasRoleLevel(6))
                <li class="treeview @if ($active_tab=='item') {{'active'}} @endif ">
                    <a href="{{route('pro_dashboard')}}" >
                        <i class="fa fa-dashboard"></i> <span>Dashboard</span> 
                    </a>             
                </li> 
                <li class="active"><a href="{{route('profile_detail')}}"><i class="fa fa-user"></i> Profile</a></li>
                <li class="active"><a href="{{route('password_edit')}}"><i class="fa fa-key "></i>Change password</a></li>
                
                <!--<li class="active"><a href="{{route('my_restaurant_list')}}"><i class="fa fa-tasks"></i> Restaurant list</a></li>-->
                <?php $restaurant_id = auth()->user()->getOwnerRestauant(); ?>
                @if(!empty($restaurant_id))
                <li class="active">                    
                    <a href="{{route('my_restaurant_edit',['id'=>$restaurant_id])}}"><i class="fa fa-edit"></i> My restaurant</a>                   
                </li>                
                <li class="treeview @if ($active_tab=='menu') {{'active'}} @endif ">
                    <a href="/admin/menus/{{$restaurant_id}}">
                        <i class="fa fa-cutlery"></i> My dish 
                    </a>
                </li>  
                @else
                <li class="active">   
                    <a href="{{route('my_restaurant_add')}}"><i class="fa fa-edit"></i> My restaurant</a>
                </li>
                <li class="disabled">   
                    <a href="javascript:void(0);" class="disabled"><i class="fa fa-edit"></i> My dish</a>
                </li>
                @endif
            @endif
        @endif                        
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>