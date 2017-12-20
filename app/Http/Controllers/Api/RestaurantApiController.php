<?php

namespace App\Http\Controllers\Api;
use App\Menu;
use App\Ultility\Constant;
use App\Restaurant;
use App\Events\ItemCreatedEvent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RestaurantApiController extends Controller
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
     * 
     * @return string
     */
    public static function get_defined_valid_rule($request) {
               
        $rules = [
                    'address' => 'required|max:191',
                    'year'=>'digits_between:0,9999,min:1|max:4',
                    'legal_effectif_min'=>'nullable|integer',
                    'legal_effectif_max'=>'nullable|integer',                    
                    'phone' => 'required|regex:/^[\+]{1}[0-9]{9,20}$/|max:20',
                    'lat' => 'required',
                    'lng' => 'required',
                    'status'=>'in:active,inactive',
                    'verify_status'=>'in:pending,verified,closed',
                ];
        
        $phone = $request->get('phone');
        $name = $request->get('name');
        if(!empty($phone) && !empty($name)){  
            $phone = preg_replace('/\s+/', '', trim($phone));
            $rules['name'] =  'required|max:191|unique_restaurant:'.$phone.',0';
        }
        return $rules;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function addResto(Request $request)
    {        
        $results = ['status'=>'ok','data'=>[],'message'=>''];
        
        $validator = validator($request->all(), $this->get_defined_valid_rule($request));
        //$this->validate($request, $this->get_defined_valid_rule('add'));
        if ($validator->fails()) {                                
            $errors = $validator->errors();
            $results['message'] = implode(";", $errors->all());
        }else{
            $restaurant_data = $request->all();
            
            $restaurant_data['phone'] = preg_replace('/\s+/', '', trim($restaurant_data['phone']));
            $restaurant_data['type_id'] = 1;
            $restaurant_data['user_id'] = 2;
            $restaurant_data['verify_status'] = Constant::VERIFIED_STATUS; 
            $restaurant = Restaurant::create($restaurant_data);

            if($restaurant instanceof Restaurant){

                //event(new ItemCreatedEvent($restaurant,NULL));   

                $results['data'] = ['restaurant_id'=>$restaurant->id];

            }else{
                $results['message'] = 'Something went wrong. Please try again!';                    
            }               
        }    
        return response()->json($results, 200);    
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function detailRestaurant(Request $request, $id,$date=null)
    {                     
        
        $data = ['status'=>'ok','data'=>[],'message'=>''];
        
        /*$date_query = (empty($date))?date('Y-m-d',time()):date('Y-m-d', strtotime($date));
        
        $restaurantObj = Restaurant::with(['menus' => function ($query) use($date_query) {
                    //$query->select(['menus.id','menus.name','menus.description','menus.price','menus.from_date','menus.to_date','menus.status']);
                    $query->where('menus.from_date','<=',$date_query);
                    $query->where('menus.to_date','>=',$date_query);                    
                }])->select(['restaurants.id','restaurants.name','restaurants.address','restaurants.phone','restaurants.lat','restaurants.lng','restaurants.status'])
                    ->where('id',$id)->first();*/
        $restaurantObj = Restaurant::select(['restaurants.id','restaurants.name','restaurants.currency','restaurants.address','restaurants.phone','restaurants.lat','restaurants.lng'])->find($id);
        
        if($restaurantObj){
            $restaurant = $restaurantObj->toArray();
            
            $menus_res = [];

            $date_query = (empty($date))?date('Y-m-d',time()):date('Y-m-d', strtotime($date));

                $menus = Menu::with(['foods' => function($query) {
                                        $query->select('id', 'name');
                                    },
                                    'category' => function($query) {
                                        $query->select('id', 'name');
                        }])->select(['menus.id','menus.name','menus.description','menus.price','menus.from_date','menus.to_date','menus.status','menus.category_id'])
                            ->where('restaurant_id',$id)
                            ->where('status','active')
                            ->where('from_date','=',$date_query)
                            ->where('to_date','=', $date_query)
                            ->get();

                if($menus){
                    $menus_res = $menus->toArray();
                }
            $restaurant['menus'] = $menus_res;
            $data = ['status'=>'ok','data'=>['restaurant'=>$restaurant],'message'=>''];
        }else{
            $data['message'] = 'Data not found!';
        }
        
        return response()->json($data, 200);        
    }
   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function nearbyFoods(Request $request)
    {                
        $lat = $request->get("lat");
        $lng = $request->get("lng"); 
        $dish = $request->get("dish");
        $page = (empty($request->get("page")))?1:intval($request->get("page"));
        $per_page = (empty($request->get("per_page")))?50:intval($request->get("per_page"));
       // $q = $request->get("q");
        
        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'lng' => 'required',
        ]);
        
        $data = ['status'=>'ok','data'=>[],'message'=>''];        
        
        if (!$validator->fails()) {
            
            $items = Restaurant::getAllDishNearbyApi($lat, $lng, $dish, $page, $per_page);
            
            $data['data'] = $items;
        }else{
            $data['message'] = 'Params is not valid!';
        }
        
       return response()->json($data, 200);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function nearbyRestaurants(Request $request)
    {        
        $q = $request->get("q");
        $lat = $request->get("lat");
        $lng = $request->get("lng");
        
        $page = (empty($request->get("page")))?1:intval($request->get("page"));
        $per_page = (empty($request->get("per_page")))?50:intval($request->get("per_page"));
        
        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'lng' => 'required',
        ]);
        
        $data = ['status'=>'ok','data'=>[],'message'=>''];        
        
        if (!$validator->fails()) {
            $items = Restaurant::getRestaurantsSearchApi($q, $lat, $lng,$page,$per_page);   
            $data['data'] = $items;
            
         }else{
            $data['message'] = 'Params is not valid!';
        }
        
        return response()->json($data, 200);
    }
     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function favouriteRestaurants(Request $request)
    {
        $q = $request->get("q");
        $lat = $request->get("lat");
        $lng = $request->get("lng");                             
        $fav_res = $request->get("fav_res"); 
        
        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'lng' => 'required',
            'fav_res' => 'required',
        ]);
        
        $data = ['status'=>'ok','data'=>[],'message'=>''];        
        
        if ($validator->fails()) {
            $data['message'] = "Params is not valid!";
        }else{
            $favResIds = explode(",",$fav_res);
            $items = Restaurant::getRestaurantsFavourite($q, $lat, $lng,$favResIds);
            
            $data['data'] = $items;
        }
        
        return response()->json($data, 200);        
    }   
}
