<?php

namespace App\Http\Controllers;

//use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Menu;
use App\FoodType;
use App\Package;
use App\Restaurant;
use App\MenuFoodType;
use App\UserExperience;
use Illuminate\Http\Request;
use App\Ultility\Constant;
use App\Ultility\UltiFunc;
use App\Events\DishCreatedEvent;
use App\Events\ItemCreatedEvent;
use Illuminate\Validation\Rule;
//use GuzzleHttp\Client;
use Illuminate\Support\Facades\View;
//use Illuminate\Support\Facades\Input;

class QuickaddController extends Controller
{
    public $active_tab;
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {                        
        $this->active_tab = 'menu';
        View::share ( 'active_tab', $this->active_tab );
        View::share ( 'page', 'menu' );      
       
    }
  
    /**
     * 
     * @return string
     */
    public static function get_defined_valid_rule($type) {
        
        $rules = ['name' => 'required|max:191',
                    'description' => 'max:500',                   
                    'from_date'=>'required|date',                    
                    'price' =>'nullable|regex:/^(\d+(?:[\.\,]\d{1,2})?)$/' ,
                    'category_id'=>'required|integer'
                ];
        return $rules;
    }
   
   
    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function createQuick(Request $request)
    {   
        $results = ['restaurants'=>[],'next_page'=>''];
        
        list($lat,$lng,$cookie) = UltiFunc::getLatLng($request);
        
        if(!empty($lat) && !empty($lng)){            
            $results = UltiFunc::getRestosFromGoogle($lat,$lng,NULL);            
        }
        
        return view('menu.create_quick', $results);
    }
     /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function ajaxRestaurants(Request $request)
    {   
        $results = ['restaurants'=>[],'next_page'=>''];
        
        list($lat,$lng,$cookie) = UltiFunc::getLatLng($request);
        
        $page_token = $request->get('page_token');

        if(!empty($page_token)){
            $results = UltiFunc::getRestosFromGoogle($lat,$lng,$page_token);
        } 
        
        return response()->json(array('status' => 'ok','data'=>$results));  
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function createQuickStep2(Request $request,$place_id = null)
    {
        $restaurant = [];
        if(!empty($place_id)){
            list($lat,$lng,$cookie) = UltiFunc::getLatLng($request);
            
            $restaurant = UltiFunc::getRestoDetailGoogle($place_id, $lat, $lng);
            
            if(count($restaurant) <=0){
                $request->session()->flash("fail_message", "Data not found!");
                
                return redirect()->route('restos_google_list');
            }
        }else{
            $restaurant = UltiFunc::getInitRestoDetail();
        }
        
        $food_cats = FoodType::all();
        
        return view('menu.create_quick_step2', ['restaurant'=>$restaurant,'food_cats'=>$food_cats]);
    } 
    
     /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function storeQuickStep2(Request $request)
    {        
        
        $datas = $request->all();
        $restaurant_id = $request->get('restaurant_id');
        
        $rules = $this->getValidRuleQuickAdd($request);
        
        $validator = validator($request->all(), $rules);        
        
        if (!$validator->fails()) {
            if(empty($restaurant_id)){
                $restaurant_data = [
                    'name'=>$datas['restaurant_name'],
                    'address'=>$datas['restaurant_address'],
                    'google_id'=>$datas['google_id'],
                    'lat'=>$datas['lat'],
                    'lng'=>$datas['lng'],
                    'phone'=>$datas['phone'],
                    'description'=>$datas['description'],
                    'type_id' =>1,
                    'user_id' =>2,
                    'status'=> Constant::ACTIVE_STATUS,                    
                ];
                if(auth()->check() && auth()->user()->hasRoleLevel([9,12])){
                    $restaurant_data['verify_status'] = Constant::VERIFIED_STATUS;                     
                }else{
                    $restaurant_data['verify_status'] = Constant::PENDING_STATUS;                    
                }
                $restaurant = Restaurant::create($restaurant_data);

                if($restaurant instanceof Restaurant){
                    $restaurant_id = $restaurant->id;                   
                }                
            }else{                
                $restaurant = Restaurant::find($restaurant_id);
            }
            
            if($restaurant instanceof Restaurant){ 
                if(auth()->check() && auth()->user()->hasRoleLevel([9,12])){
                    $menu_status = Constant::ACTIVE_STATUS;
                }else{
                    $menu_status = ($restaurant->verify_status == Constant::PENDING_STATUS)?Constant::ACTIVE_STATUS:Constant::INACTIVE;
                }
                //save food category
                $food_cats = '';
                $foods = $request->get('foods',[]);  
                if(!empty($foods)){
                    $food_cats = ',' . implode(",", $foods) . ',';
                }
                $menu = Menu::create([
                        'name'=>$datas['name'],
                        'price'=> UltiFunc::tofloat($datas['price']),
                        'restaurant_id'=>$restaurant_id,
                        'category_id'=>2,
                        'from_date'=>date('Y-m-d',time()),
                        'to_date'=>date('Y-m-d',time()) ,
                        'food_cats'=>$food_cats,
                        'status'=>$menu_status
                        ]);
                if($menu){
                                
                    $insertMenuFood = MenuFoodType::insertMenuFoodType($menu->id, $foods);
                                        
                    if($restaurant->verify_status == Constant::PENDING_STATUS){
                        event(new ItemCreatedEvent($restaurant,$menu));                         
                    }else{
                        
                        if ($menu->status == Constant::INACTIVE) {
                            event(new DishCreatedEvent($restaurant,$menu));
                        }
                    }
                    $request->session()->flash("success_message", "Menu is created."); 
                    //return redirect()->route('dish_quick_add',['place_id'=>$restaurant_id]);
                     return redirect()->route('dish_thankyou',['resto_id'=>$restaurant_id]);
                }else{
                    $request->session()->flash("fail_message", "Please try again!");
                    
                    return redirect()->route('dish_quick_add',['place_id'=>$request->get('place_id')]);
                }               
                //return redirect()->route('menu_add_quick');
            }
        }else{
            $request->session()->flash("fail_message", "Form is invalid!");
        }
        
        return redirect()->route('dish_quick_add',['place_id'=>$request->get('place_id')]) ->withErrors($validator)
                            ->withInput();
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
                'name' => 'required|max:191|unique_menu_name:'.date('Y-m-d').','.$restaurant_id.',0',
                'price' =>'nullable|regex:/^(\d+(?:[\.\,]\d{1,2})?)$/',
                'restaurant_id' => 'exists:restaurants,id'
            ];
        }else{
            $rules = [
                'name' => 'required|max:191',
                'price' =>'nullable|regex:/^(\d+(?:[\.\,]\d{1,2})?)$/',
                //'restaurant_name' => 'required|max:191',                   
                'restaurant_address'=>'required|max:191',
                'google_id' =>[ 'nullable',
                                Rule::unique('restaurants','google_id')->where(function ($query) {
                                    $query->whereNull('deleted_at');
                                })],
                'phone'=>'required|regex:/^[\+]{1}[0-9]{9,20}$/|max:20',
                'lat'=>'required',
                'lng'=>'required'
            ];
            $address = $request->get('restaurant_address');
            $phone = $request->get('phone');
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
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function dishThankyou($resto_id)
    {          
        $packages  = Package::where('status','active')->get();
        return view('menu.thankyou', ['resto_id'=>$resto_id,'packages'=>$packages]);
    }
     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function likeQuickMenu(Request $request)
    {
        
        $like = $request->get('like');
        
        $userExperience = new UserExperience();
        $userExperience->user_id = empty(auth()->id())?0:auth()->id();
        $userExperience->like = $like;
        $userExperience->page = 'dish_add';
        
        $userExperience->save();
        
        return response()->json(array('status' => 'ok','data'=>$userExperience->id));                  
    } 
     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function commentQuickMenu(Request $request)
    {
        $user_exp_id = $request->get('user_exp_id');
        $comment = $request->get('comment');
        if(!empty($user_exp_id)){
            $userExperience = UserExperience::find($user_exp_id);
            if($userExperience){
            
                $userExperience->comment = $comment;

                $userExperience->save();
                
                $request->session()->flash("success_message", "Thank you for your comment."); 
            }else{
                $request->session()->flash("fail_message", "Something went wrong!"); 
            }
        }else{
            $request->session()->flash("fail_message", "Something went wrong!"); 
        }
        
        $resto_id = $request->get('resto_id');
        if(!empty($resto_id)){
            return redirect()->route('dish_quick_add',['place'=>$resto_id]);
        }
        
        return redirect()->route('dish_quick_add');                  
    } 
}
