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
							<li class="tabs-list-li "><a attr-id="2" href="#" class="tabs-list">{{ __('homepage.Logiciel_de_caisse') }}</a></li>
							<li class="tabs-list-li ">
								<a attr-id="3" href="#" class="tabs-list" id="favorite_tab">{{ __('homepage.manual') }}</a>                                
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
									<br>
                                    <!--<div class="col-md-2 col-sm-3 text-center">
                                        <a class="story-title" href="#"><img alt="" src="https://charitablebookings.org/tm365/wp-content/uploads/2017/02/van-innnTTTT.jpg" style="width:100px;height:100px" class="img-circle"></a>
                                    </div>-->                                                   
                                    <div class="col-md-8">   
                                    	<div><h4><strong>Features</strong></h4></div>

                                    	<h1>Les fonctions pour le professionnel</h1>
										<ul>
											<li>Diffusez votres menu a plus de 200 000 visiteurs dans un rayon de 1km</li>
											<li>Acceptez les reservations en ligne sans frais et commission</li>
											<li>Connecter votre logiciel de caisse avec Vamanger</li>
										</ul>
                                    	

                                    	<h2>Mode d'emploi</h2>

                                    	<p>Parce qu'il en faut un pour faire des jolies photos qui vont donner envi a vos clients de venir. </p>

                                    	<p>Peut mettre a jour votre plat du jour. </p>
                                    	<p>Pour mettre a jour votre profil. </p>

                                    </div>
                                        <!--<div class="col-md-4">                                    
                                        <div class="img-thumbnail">
                                         <img src="http://lorempixel.com/90/90/food/<?php// echo rand(1, 10);?>" class="media-object img-rounded" style="width:90px">
                                        </div>
                                    </div>  -->
                                </div>
                            </div>                                                                       
                        </div>                       
                        <!--<a href="/" class="btn btn-primary pull-right btnNext">More <i class="glyphicon glyphicon-chevron-right"></i></a>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
