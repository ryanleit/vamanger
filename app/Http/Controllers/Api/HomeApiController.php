<?php

namespace App\Http\Controllers\Api;

use App\Ultility\Constant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Validator;

class HomeApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }
    
    /**
     * Show info about vamanger
     *
     * @return \Illuminate\Http\Response
     */
    public function about(Request $request)
    {                     
        
        $data = ['status'=>'ok','data'=>[],'message'=>''];
                
        $data = [
            'home_page'=>[
                            'title'=>'Vamanger',
                            'url' => 'https://vamanger.com'
                        ],
            'website_info' =>[
                            'map' => [
                                'pro'=>[
                                    [
                                        'title' => 'Pro Information',
                                        'link' =>'https//vamanger.com/pro'
                                    ],
                                    [
                                        'title' => 'Reseller',
                                        'link' =>'https//vamanger.com/pro/privacy'
                                    ],
                                    [
                                        'title' => 'Privacy',
                                        'link' =>'https//vamanger.com/pro/privacy'
                                    ],
                                    [
                                        'title' => 'Terms of services',
                                        'link' =>'https//vamanger.com/pro/term-service'
                                    ],
                                    [
                                        'title' => 'Features',
                                        'link' =>'https//vamanger.com/pro/features'
                                    ],
                                    [
                                        'title' => 'Price',
                                        'link' =>'https//vamanger.com/pro/price'
                                    ],
                                    [
                                        'title' => 'Price',
                                        'link' =>'https//vamanger.com/pro/contact'
                                    ]
                                ],
                                'normal'=>[
                                    [
                                        'title' => 'Features',
                                        'link' =>'https//vamanger.com/features'
                                    ],
                                    [
                                        'title' => 'Privacy',
                                        'link' =>'https//vamanger.com/pro/privacy'
                                    ],
                                    [
                                        'title' => 'Terms of services',
                                        'link' =>'https//vamanger.com/term-service'
                                    ],
                                    [
                                        'title' => 'About us',
                                        'link' =>'https//vamanger.com/term-service'
                                    ],
                                    [
                                        'title' => 'Terms of services',
                                        'link' =>'https//vamanger.com/term-service'
                                    ],
                                ]
                            ],
                'content' => [
                        'Reserver par telephone',
                        'Filtre vegetaraien, sans gluten, halal',
                        'Disponible dans plusieurs pays'
                ],
                'contact' => [
                                'name' => 'Sylvain Pham',
                                'email' => 'contact@vamanger.com',
                                'phone' => '+33 770 26 99'
                            ],  
            ]
        ];
        return response()->json($data, 200);        
    }     
}
