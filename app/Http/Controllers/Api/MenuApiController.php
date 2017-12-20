<?php

namespace App\Http\Controllers\Api;

use App\Menu;
use App\Restaurant;
use GuzzleHttp\Client;
//use App\Events\DishCreatedEvent;
use App\Ultility\Constant;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
//use App\Events\ItemCreatedEvent;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Validator;

class MenuApiController extends Controller
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
    public static function get_defined_valid_rule($type) {
        
        $rules = ['name' => 'required|max:191',
                    'address' => 'required|max:191',
                    'phone' => 'required|max:20',                    
                    'lat' => 'required',
                    'lng' => 'required',                   
                ];
        return $rules;
    }
     /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function getRestaurantsGoogle(Request $request)
    {   
        $results = ['status'=>'ok','data'=>[],'message'=>''];
        
        $next_page = '';
        $restaurants = [];        
                
        $validator = validator($request->all(), ['lat'=>'required','lng'=>'required']);            
        if (!$validator->fails()) {  
                    
            $lat = $request->get('lat');
            $lng = $request->get('lng');
            $page_token = $request->get('page_token');
            
            if($page_token){
                $data_query = [
                    'pagetoken'=>$page_token,
                    'key' =>'AIzaSyAeWXXFUIv-_Fp-YVZlxERrxdadDfwr0pQ',
                ];
            }else{
                $data_query = [
                    'location'=> implode(",", [$lat,$lng]),
                    //'radius' =>'1000',
                    'rankby'=>'distance',
                    'type' =>'restaurant',
                    'key' =>'AIzaSyAeWXXFUIv-_Fp-YVZlxERrxdadDfwr0pQ',
                ];
            }
            
            $client = new Client();
            
            $res = $client->request('GET', 'https://maps.googleapis.com/maps/api/place/nearbysearch/json', [
                'verify' => false,
                'query' => $data_query
            ]);
            if($res->getStatusCode() == 200){
                $resultBody = $res->getBody();            
                $result = json_decode($resultBody,true);
                
                if(isset($result['results']) && count($result['results']) > 0){
                    
                    if(isset($result['next_page_token'])){
                        $next_page = $result['next_page_token'];
                    }
                    
                    foreach($result['results'] as $data){
                        $restaurants[] = $this->getRestoDetail($data, $lat, $lng);                       
                    }
                    
                    $results['data'] = ['next_page_token'=>$next_page,'data'=>$restaurants];
                }
            }else{
                $results['message'] = 'Data not found!';
            }
        }else{
            $errors = $validator->errors();
            $results['message'] = implode(";", $errors->all());
        }
        
        return response()->json($results, 200);                        
    }
     /**
     * @Desc get restaurants nearby from google api
     *
     * @return json
     */
    public function restaurantsGoogle(Request $request)
    { 
        $results = ['status'=>'ok','data'=>[],'message'=>''];
        
        $next_page = '';
        $restaurants = [];                        

        $validator = validator($request->all(), ['lat'=>'required','lng'=>'required','page_token'=>'required']);            
        if (!$validator->fails()) {
            $lat = $request->get('lat');
            $lng = $request->get('lng');
            $page_token = $request->get('page_token');
            
            $data_query = [
                'pagetoken'=>$page_token,
                'key' =>'AIzaSyAeWXXFUIv-_Fp-YVZlxERrxdadDfwr0pQ',
            ];
        
            $client = new Client();

            $res = $client->request('GET', 'https://maps.googleapis.com/maps/api/place/nearbysearch/json', [
                'verify' => false,
                'query' => $data_query
            ]);
            if($res->getStatusCode() == 200){
                $resultBody = $res->getBody();            
                $result = json_decode($resultBody,true);

                if(isset($result['results']) && count($result['results']) > 0){
                    if(isset($result['next_page_token'])){
                        $next_page = $result['next_page_token'];
                    }
                    
                    foreach($result['results'] as $data){                        
                        $restaurants[] = $this->getRestoDetail($data, $lat, $lng);
                    }
                    
                    $results['data'] = ['next_page_token'=>$next_page,'data'=>$restaurants];
                }
            }else{
                $results['message'] = 'Data not found!';
            }
        }else{
            $errors = $validator->errors();
            $results['message'] = implode(";", $errors->all());
        }
        
        return response()->json($results,200);  
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function getDetailRestoGoogle(Request $request,$place_id = null)
    {
        $results = ['status'=>'ok','data'=>[],'message'=>''];
        $restaurant = [];
        $validator = validator($request->all(), ['lat'=>'required','lng'=>'required']);            
        if (!$validator->fails()) {         
            $client = new Client();
           //https://maps.googleapis.com/maps/api/place/details/json?placeid=ChIJN1t_tDeuEmsRUsoyG83frY4&key=YOUR_API_KEY
            $res = $client->request('GET', 'https://maps.googleapis.com/maps/api/place/details/json', [
                'verify' => false,
                'query' => [
                    'placeid'=>$place_id,
                    'key' =>'AIzaSyAeWXXFUIv-_Fp-YVZlxERrxdadDfwr0pQ',
                ]
            ]);
            if($res->getStatusCode() == 200){
                $lat = $request->get('lat');
                $lng = $request->get('lng');

                $resultBody = $res->getBody();            

                $result = json_decode($resultBody,true);
                
                if(isset($result['result']) && count($result['result']) > 0){
                    $data = $result['result'];
                    $restaurant = $this->getRestoDetail($data, $lat, $lng);                    
                }
            }else{
                $results['message'] = "Google API is fail!";
            }    
        }else{
            $errors = $validator->errors();
            $results['message'] = implode(";", $errors->all());
        }
        
        $results['data'] = $restaurant;
        
        return response()->json($results,200); 
    }
    /**
     * 
     * @param type $data
     */
    public function getRestoDetail($data, $lat, $lng){
        $restaurant = [];
        $phone = isset($data['international_phone_number'])?preg_replace('/\s+/', '', trim($data['international_phone_number'])):'';
        
        $restaurantObj = $this->getResto($data['id'], NULL);
        if(!$restaurantObj){
            $restaurant['id'] = NULL;
            $restaurant['name'] = $data['name'];
            $restaurant['address'] = $data['vicinity'];
            $restaurant['phone'] = $phone;
            $restaurant['lat'] = $data['geometry']['location']['lat'];
            $restaurant['lng'] = $data['geometry']['location']['lng'];
            $restaurant['google_id'] = $data['id'];
            $restaurant['place_id'] = $data['place_id'];
            $restaurant['menus_count'] = 0;
            $distanceInfo = $this->getDistanceBetweenPointsNew($lat, $lng, $restaurant['lat'], $restaurant['lng']);
            $restaurant['distance'] = round($distanceInfo['kilometers'],4);
        }else{
            $restaurant['id'] = $restaurantObj->id;
            $restaurant['name'] = $restaurantObj->name;
            $restaurant['address'] = $restaurantObj->address;
            $restaurant['phone'] = $restaurantObj->phone;
            $restaurant['lat'] = $restaurantObj->lat;
            $restaurant['lng'] = $restaurantObj->lng;
            $restaurant['menus_count'] = empty($restaurantObj->menus_count)?0:$restaurantObj->menus_count;
            $distanceInfo = $this->getDistanceBetweenPointsNew($lat, $lng, $restaurantObj->lat, $restaurantObj->lng);
            $restaurant['distance'] = round($distanceInfo['kilometers'],4);
            $restaurant['google_id'] = $data['id'];
            $restaurant['place_id'] = $data['place_id'];
        }
        
        return $restaurant;
    }
   
    /**
     * 
     * @param type $phone
     * @return type
     */
    public function getResto($google_id, $phone) { 
        
        $now = date('Y-m-d',time());
        $query = Restaurant::withCount(   
            ['menus' => function ($query) use($now){
                $query->where('status', Constant::ACTIVE_STATUS)
                    ->where('menus.from_date','<=',$now)
                    ->where('menus.to_date','>=',$now);        
            }])->where('google_id',$google_id);
        
        if(!empty($phone)){
           $query = $query->orWhere('phone',$phone);        
        }
        
        $restaurant = $query->first();      
        
        return $restaurant;        
    }
     /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function storeMenuGoogle(Request $request)
    {
        $results = ['status'=>'ok','data'=>[],'message'=>''];
        
        $datas = $request->all();
        $restaurant_id = $request->get('restaurant_id');
        
        if($restaurant_id){
            $restaurant = Restaurant::find($restaurant_id);
            
            if(empty($restaurant)){
                $results['message'] = "Restaurant is not exist!";
                
                return response()->json($results,200);
            }
            $rules = [
                'dish_name' => 'required|max:191|unique_menu_name:'.date('Y-m-d').','.$restaurant_id.',0',                
                'dish_price' =>'nullable|numeric'
            ];
        }else{
             $rules = [
                'dish_name' => 'required|max:191',  
                'dish_price' =>'nullable|numeric',
                'restaurant_address'=>'required|max:191',
                'google_id' =>[ 'nullable',
                                Rule::unique('restaurants','google_id')->where(function ($query) {
                                    $query->whereNull('deleted_at');
                                })],
                'restaurant_phone'=>'required|regex:/^[\+]{1}[0-9]{9,20}$/|max:20',
                'lat'=>'required',
                'lng'=>'required'
            ];
            $address = $request->get('restaurant_address');
            $phone = $request->get('restaurant_phone');
            $name = $request->get('restaurant_name');
            
            $rules['restaurant_name'] =  ['required','max:191'];
            
            if(!empty($name) && !empty($phone)){                  
                $phone = preg_replace('/\s+/', '', trim($phone));
                $rules['restaurant_name'][] =  'unique_restaurant:'.$phone.',0';                                           
            }
            
            if(!empty($name) && !empty($address)){                                 
                $rules['restaurant_name'][] =  Rule::unique('restaurants','name')->where(function ($query) use($address) {
                                            $query->where('address',$address)->whereNull('deleted_at');
                                        });
                                            
            }     
        }               
        
        $validator = validator($request->all(), $rules);        
        
        if (!$validator->fails()) {
            
            //$results['data'] = ['place_id'=>$request->get('place_id')];
            if(empty($restaurant_id)){
                $restaurant_data = [
                    'name'=>$datas['restaurant_name'],
                    'address'=>$datas['restaurant_address'],
                    //'google_id'=>$datas['google_id'],
                    'lat'=>$datas['lat'],
                    'lng'=>$datas['lng'],
                    'phone'=>preg_replace('/\s+/', '', trim($datas['restaurant_phone'])),                    
                    'type_id' =>1,
                    'user_id' =>2,
                    'status'=> Constant::ACTIVE_STATUS,
                    'verify_status'=> Constant::VERIFIED_STATUS
                ];
                if(isset($datas['google_id'])){
                    $restaurant_data['google_id'] = $datas['google_id'];
                }
                if(isset($datas['restaurant_description'])){
                    $restaurant_data['description'] = $datas['restaurant_description'];
                }
                $restaurant = Restaurant::create($restaurant_data);

                if($restaurant instanceof Restaurant){                       
                    $restaurant_id = $restaurant->id;
                }
            }
            
            if(!empty($restaurant_id)){
                $menu = Menu::create([
                        'name'=>$datas['dish_name'],
                        'price'=>(isset($datas['dish_price']))?$this->tofloat($datas['dish_price']):0,
                        'restaurant_id'=>$restaurant_id,
                        'category_id'=>2,
                        'from_date'=>date('Y-m-d',time()),
                        'to_date'=>date('Y-m-d',time()),
                        ]);
                if($menu){
                   /* if(isset($restaurant) && $restaurant->trashed()){
                        event(new DishCreatedEvent($restaurant,$menu));
                    }*/
                    $results['data'] = array_merge($results['data'],['restaurant_id'=>$restaurant_id,'menu_id'=>$menu->id]);                           
                }else{
                    $results['data'] = array_merge($results['data'],['restaurant_id'=>$restaurant_id]);
                    $results['message'] = 'Menu created is fail.';
                }
                
            }else{
                $results['message'] = 'Restaurant Id can not empty!';
            }
        }else{
            $errors = $validator->errors();
            $results['message'] = implode(";", $errors->all());
        }
        
        return response()->json($results,200); 
    }  
     /**
     * 
     * @param type $request
     * @return string
     */
    public function getValidRuleQuickAdd($request) {
        $restaurant_id = $request->get('restaurant_id');
        
        if($restaurant_id){
            $rules = [
                'dish_name' => 'required|max:191|unique_menu_name:'.date('Y-m-d').','.$restaurant_id.',0',
                //'restaurant_id' => 'exists:restaurants,id'
            ];
        }else{
            $rules = [
                'dish_name' => 'required|max:191',                
                'restaurant_address'=>'required|max:191',
                'google_id' =>[ 'nullable',
                                Rule::unique('restaurants','google_id')->where(function ($query) {
                                    $query->whereNull('deleted_at');
                                })],
                'restaurant_phone'=>'required|regex:/^[\+]{1}[0-9]{9,20}$/|max:20',
                'lat'=>'required',
                'lng'=>'required'
            ];
            $address = $request->get('restaurant_address');
            $phone = $request->get('restaurant_phone');
            $name = $request->get('restaurant_name');
            if(!empty($phone) && !empty($name)){              
                $rules['restaurant_name'] =  ['required',
                                            'max:191',
                                            'unique_restaurant:'.$phone.',0',
                                            Rule::unique('restaurants','name')->where(function ($query) use($address) {
                                                $query->where('address',$address)->whereNull('deleted_at');
                                            })
                                            ];
            }
        }
        
        return $rules;
    }
    /**
     * 
     * @param type $num
     * @return type
     */
    public function tofloat($num) {
        $dotPos = strrpos($num, '.');
        $commaPos = strrpos($num, ',');
        $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos :
            ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);

        if (!$sep) {
            return floatval(preg_replace("/[^0-9]/", "", $num));
        }
        
        return floatval(
            preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
            preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)))
        );
    }
    /**
     * 
     * @param type $latitude1
     * @param type $longitude1
     * @param type $latitude2
     * @param type $longitude2
     * @return type
     */
    function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2){
        $theta = $longitude1 - $longitude2;
        $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);$miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        
        return compact('miles','feet','yards','kilometers','meters');
    }
}
