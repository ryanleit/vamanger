<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Restaurant;
use App\FoodType;
use App\Ultility\UltiFunc;
use Illuminate\Support\Facades\View;
//use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
//use Riverskies\Laravel\MobileDetect\Facades\MobileDetect;
//use Illuminate\Support\Facades\File;
class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        $params_search = $this->getParamsSearch($request);
        
        list($lat,$lng,$cookie) = UltiFunc::getLatLng($request);
        
        $page = empty($params_search['foods'])?'home':'search';
        
        $items = Restaurant::getAllDishNearbyLimit($lat, $lng,$params_search);
        
        $food_cats = FoodType::all();
        $isMobile = app('mobile-detect')->isMobile();
        if(empty($cookie)){
            if($isMobile){
                return View::make('home.home_mobile',array('res_items'=>$items,'food_cats'=>$food_cats,'page'=>$page));     
            }else{
               
                return View::make('home.home_desktop',array('res_items'=>$items,'food_cats'=>$food_cats,'page'=>$page));  
            }
        }else{
            if($isMobile){ 
                $view = View::make('home.home_mobile',array('res_items'=>$items,'food_cats'=>$food_cats,'page'=>$page));                  
            }else{
                
                $view = View::make('home.home_desktop',array('res_items'=>$items,'food_cats'=>$food_cats,'page'=>$page));  
            }
            return Response::make($view,200)->withCookie($cookie);  
        } 
    }
    /**
     * 
     * @param type $request
     */
    public function getParamsSearch($request) {
        $params = [];
        //save food category
        $params['foods'] = $request->get('foods',[]); 
        $params['dish_name'] = $request->get('dish_name','');
        $params['restaurant_name'] = $request->get('restaurant_name','');
        
        return $params;
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function features()
    {
        return view('home/features',['page'=>'features']);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function aboutus()
    {
        return view('home/aboutus',['page'=>'aboutus']);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function termService()
    {
        return view('home/term_service',['page'=>'terms']);
    } /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function privacy()
    {
        return view('home/privacy',['page'=>'privacy']);
    }
     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function api()
    {
        return view('home/api',['page'=>'api']);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function homePro()
    {
        return view('home/homepro',['page'=>'homepro']);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function proFeatures()
    {
        return view('home/pro/features',['page'=>'features']);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function proPrice()
    {
        return view('home/pro/price',['page'=>'price']);
    }
     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function proContact()
    {
        return view('home/pro/contact',['page'=>'contact']);
    }
    
     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function proApi()
    {
        return view('home/pro/api',['page'=>'api']);
    }
     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function proReseller()
    {
        return view('home/pro/reseller',['page'=>'reseller']);
    }
     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function proTermService()
    {
        return view('home/pro/term_service',['page'=>'terms']);
    } /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function proPrivacy()
    {
        return view('home/pro/privacy',['page'=>'privacy']);
    }
    
}
