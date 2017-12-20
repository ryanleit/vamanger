<?php

namespace App\Http\Controllers;

use App\Menu;
use App\MenuFoodType;
use App\Restaurant;
use App\Ultility\Constant;
use App\Ultility\UltiFunc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class RestaurantController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        View::share ( 'page', 'resto' );
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function increaseRestoView($restaurantObj)
    {                
        $count = intval($restaurantObj->view_count);
        $restaurantObj->view_count = $count + 1;
        
        return $restaurantObj->save();          
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function detailRestaurant(Request $request, $id,$date=null)
    {        
      
        $restaurantObj = Restaurant::with('menus')->find($id);
        if($restaurantObj){            
            $restaurant = $restaurantObj->toArray();
            $dt = new \DateTime();     
            $today = $dt->format('Y-m-d');
            $preDt = $dt->modify( '-1 day' )->format("Y-m-d");
            $nextDt = $dt->modify( '+2 day' )->format("Y-m-d");
            $date_arr = ['preDt'=>$preDt,'today'=>$today,'nextDt'=>$nextDt]; 

            $menus_res = [];
            $date_query = (empty($date))?date('Y-m-d',time()):date('Y-m-d', strtotime($date));
            if($restaurant){                                                                     
                $menus = Menu::with('foods')->where('restaurant_id',$id)
                        ->where('status','active')
                        ->where('from_date','<=',$date_query)
                        ->where('to_date','>=', $date_query)
                        ->get();

                if($menus){
                    $menus_res = $menus->toArray();
                }
            }
            /* Track resto count */
            $url_referer = $request->headers->get('referer');
            if(!empty($url_referer)){
                $this->increaseRestoView($restaurantObj);
            }
            list($lat,$lng,$cookie) = UltiFunc::getLatLng($request);
            
            return response()->view('restaurant.restaurant_detail',['restaurant'=>$restaurant,
                                    'menus'=>$menus_res,
                                    'lat'=>$lat,
                                    'lng'=>$lng,
                                    'date'=>$date_query,
                                    'date_arr'=>$date_arr]); 
        }else{
            abort(404);
        }
    }
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function nearbyFoods(Request $request)
    {
      //  $q = $request->get("q");
               
        list($lat,$lng,$cookie) = UltiFunc::getLatLng($request);
                
        $items = Restaurant::getAllDishNearbyLimit($lat, $lng,'/food-nearby');
        
         if(empty($cookie)){  
            return View::make('restaurant.food_nearby',array('res_items'=>$items));     
        }else{
            $view = View::make('restaurant.food_nearby',array('res_items'=>$items)); 
            return \Illuminate\Support\Facades\Response::make($view,200)->withCookie($cookie);   
        }      
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function nearbyRestaurants(Request $request)
    {
        
        $q = $request->get("q");
        
        list($lat,$lng,$cookie) = UltiFunc::getLatLng($request);
        
        $items = Restaurant::getRestaurantsSearch($q, $lat, $lng);        
        
        //$fav_restaurants = FavoriteRestaurant::getFavResByUser(auth()->id());
        
        return View::make('restaurant.restaurant_nearby',array('res_items'=>$items,'page'=>'resto_nearby'));  
    }
     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function favouriteRestaurants(Request $request)
    {
        $q = $request->get("q");
        
        list($lat,$lng,$cookie) = UltiFunc::getLatLng($request);                     
        
        $fav_res = $request->cookie('fav-res');
        
        if(empty($fav_res)){
            $items = [];
        }else{
            $favResIds = explode(".",$fav_res);
            $items = Restaurant::getRestaurantsFavourite($q, $lat, $lng,$favResIds);
        }
        
        return View::make('restaurant.restaurant_favourite',array('res_items'=>$items,'page'=>'resto_favor'));  
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchRestaurants(Request $request)
    {
        $q = $request->get("q");
        
        list($lat,$lng,$cookie) = UltiFunc::getLatLng($request);
        
        $items = Restaurant::getRestaurantsSearch($q, $lat, $lng);
        if(empty($cookie)){  
            return View::make('restaurant.restaurant_nearby',array('res_items'=>$items));      
        }else{
            $view = View::make('restaurant.restaurant_nearby',array('res_items'=>$items)); 
            return \Illuminate\Support\Facades\Response::make($view,200)->withCookie($cookie);   
        }                
        /*
        $res_items = array();
        if($items){
            foreach ($items as $item) {
                if(!isset($res_items[$item->type_id])) $res_items[$item->type_id] = [];
                $res_items[$item->type_id][] = $item;
            }
        }
        $categories = ItemCategory::getItemCategories();        
        if(empty($cookie)){                        
            return View::make('item.list',array('res_items'=>$res_items,'categories'=>$categories,'lat'=>$lat,'lng'=>$lng));
        }else{
            $view = View::make('item.list',array('res_items'=>$res_items,'categories'=>$categories,'lat'=>$lat,'lng'=>$lng));
            return \Illuminate\Support\Facades\Response::make($view,200)->withCookie($cookie);            
        }
        */
    }
     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function autoRestaurants(Request $request)
    {
        $q = $request->get("term");
        
        
        $items = Restaurant::getAutocompleteRestaurants($q);
        
        $response = response()->json($items);
        
        return $response;        
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function cookieLatlng(Request $request)
    {
        $lat = $request->get("lat");
        $lng = $request->get("lng");
        
        $cookie = cookie();
        if($lat && $lng){
            $cookie = cookie('latlng',$lat."_".$lng,43200, '/', null, false, false);
        }
        
        $latlng = $request->cookie('latlng');
        
        return response()->json(array('status' => 'ok','latlng'=>$latlng))->withCookie($cookie);   
    }   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function cookieFavRes(Request $request)
    {
        $favRes = $request->get("favres");      
        
        $cookie = null;
        if($favRes){
            $cookie = cookie('fav-res', $favRes,null, null, null, false, false);
        }
                 
        $response = \Illuminate\Support\Facades\Response::json(array('status' => 'ok'));  
        
        if ($cookie) $response->headers->setCookie($cookie);  
        
        return $response;        
    } 
    /**
     * 
     * @param Request $request
     * @param type $code
     * @return type
     */
    public function verifyRestoStatus(Request $request, $code) {
        $str = base64_decode($code);
        $code_arr = explode("_", $str);
        
        if(count($code_arr) == 2 && $code_arr[1] == Constant::SECRET_CODE){
            $resto_id = $code_arr[0];
            
            $restaurant = Restaurant::withTrashed()->find($resto_id);
            if($restaurant){
                $restaurant->verify_status = Constant::VERIFIED_STATUS;
                
                $restaurant->save();
                
                $request->session()->flash("success_message", "Restaurant is validated.");
                
                return redirect('/');
            }else{
                $request->session()->flash("fail_message", "Restaurant is not found!");
            }
        }
        
        abort(404);
        
    }
    /**
     * 
     * @param Request $request
     * @param type $code
     * @return type
     */
    public function verifyMenuStatus(Request $request, $code) {
        $str = base64_decode($code);
        $code_arr = explode("_", $str);
        
        if(count($code_arr) == 2 && $code_arr[1] == Constant::SECRET_CODE){
            $menu_id = $code_arr[0];
            
            $menu = Menu::withTrashed()->find($menu_id);
            if($menu){
                $menu->status = Constant::ACTIVE_STATUS;
                $menu->deleted_at = NULL;
                $menu->save();
                
                $request->session()->flash("success_message", "Menu is actived.");                               
            }else{
                $request->session()->flash("fail_message", "Menu is not found!");
            }
        }else{
            $request->session()->flash("fail_message", "Link is not valid!");
        }
        
         return redirect('/');
        
    }
       /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function deleteMenu(Request $request, $id)
    {
        $menu = Menu::find($id);
        if($menu){
            $restaurantId = $menu->restaurant_id;
            $menuFoods = MenuFoodType::where('menu_id',$id)->delete();
            $del = Menu::destroy($id);   
            if($del){
                $request->session()->flash("success_message", "Menu is deleted.");                
            }else{
                $request->session()->flash("fail_message", "Please try again!");
            }
            
            return redirect('/');
        } else {
            return abort(404);
        }

        return redirect('/');
    }
}
