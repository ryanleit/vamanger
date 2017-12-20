@extends('layouts.app_pro')

@section('content')
<div class="container">
    <div class="row">              
        <div class="col-md-12"> 
            <div class="panel panel-default">
                <div class="panel-title" style="margin-bottom: 3px;">
                    <div>
                       <ul class="nav nav-tabs">
                                <li class="tabs-list-li  active "><a attr-id="1" href="#" class="tabs-list">FR</a></li>
                                 <li class="tabs-list-li "><a attr-id="2" href="#" class="tabs-list">EN</a></li>
                                 <li class="tabs-list-li ">
                                     <a attr-id="3" href="#" class="tabs-list" id="favorite_tab">DE</a>                                
                                 </li>                                    
                        </ul>
                    </div>
                </div>
                <div class="panel-body" style="background: #d3e0e9;">
                    <div class="row">
                        <!--/stories-->
                    
                        <div class="panel  panel-info">                               
                            
                            <div class="panel-body"> 
                                <div class="col-md-12">                                                                                       
                                    <div class="col-md-12">   
                                        <div><h4><strong>Pricing</strong></h4></div>
                                           <h1>Choose plan</h1>

                                        <p><img src="https://dl.dropboxusercontent.com/s/6345uyskjtr6p1d/Capture%20d%E2%80%99%C3%A9cran%202017-06-06%20%C3%A0%2002.12.23.png?dl=0" width="900px"></p>

                                    </div>
                                    
                                </div>
                            </div>                                                                       
                        </div>                       
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
