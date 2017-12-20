<?php

namespace App\Http\Controllers\Admin;

//use App\Http\Requests;


use App\Menu;
use App\FoodType;
use App\Restaurant;
use App\Category;
use App\MenuFoodType;

use App\Ultility\Constant;
use App\Ultility\UltiFunc;
use Illuminate\Http\Request;
//use App\Events\ItemCreatedEvent;
use Illuminate\Validation\Rule;
//use GuzzleHttp\Client;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class MenuController extends Controller
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
        $this->middleware(function ($request, $next) {             
           
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index($id,$order_by='from_date', $order_direct='desc')
    {
       
        $order_by         = Input::get('order_by')
                          ? Input::get('order_by')
                          : $order_by;

        $order_direct     = Input::get('order_direct')
                          ? Input::get('order_direct')
                          : $order_direct;

        $today = date('Y-m-d 00:00:00');
        $menusToday = Menu::where('restaurant_id',$id)->where('from_date','>=',$today)
                                                    ->where('to_date','<=',$today)
                                                    ->orderBy($order_by, $order_direct)->paginate(30);
        $menus = Menu::where('restaurant_id',$id)->where('from_date','<>',$today)->orderBy($order_by, $order_direct)->paginate(30);
        
        $restaurant = Restaurant::findOrFail($id);
        return view('pro.menu.index', ['menusToday'=>$menusToday,'menus'=>$menus,'restaurant'=>$restaurant])
                ->with('order_by',      $order_by)
                ->with('order_direct',  $order_direct);
    }
    /**
     * 
     * @return string
     */
    public static function get_defined_valid_rule($type,$fromDate,$restaurantId,$menuId = NULL) {
        
        $menu = [
                    'description' => 'max:500',                   
                    'from_date'=>'required|date',                    
                    'price' =>'nullable|regex:/^(\d+(?:[\.\,]\d{1,2})?)$/' ,
                    'category_id'=>'required|integer'
                ];
        if(empty($menuId)){
            $rules['name'] = 'required|max:191|unique_menu_name:'.$fromDate.','.$restaurantId.',0';
        }else{
            $rules['name'] = 'required|max:191|unique_menu_name:'.$fromDate.','.$restaurantId.','.$menuId;
        }
        return $rules;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create($id)
    {                               
        $food_cats = FoodType::all();
        
        $categories = [];
        $categoriesObj = Category::all();
        if($categoriesObj){
            $catsArr = $categoriesObj->toArray ();
            foreach ($catsArr as $cat) {
                $categories[$cat['id']] = $cat['name'];
            }
        }        
        
        return view('pro.menu.create', ['restaurant_id'=>$id,'food_cats'=>$food_cats, 'categories'=>$categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function store(Request $request,$id)
    {
        $data = $request->all();
        
        $data['price'] = $this->tofloat($data['price']);
        $data['to_date'] = $data['from_date'];
        $data['restaurant_id'] = $id;
        //$this->validate($request, $this->get_defined_valid_rule('add'));
        $validator = validator($data, $this->get_defined_valid_rule('add',$data['from_date'],$data['restaurant_id'],NULL));        

        if ($validator->fails()) {
            $request->session()->flash("fail_message", "Form invalid, Please try again!");
            return redirect()->route('menu_add',['id'=>$id])
                        ->withErrors($validator)
                        ->withInput();
        }else{
            //save food category
            $food_cats = '';
            $foods = $request->get('foods',[]);  
            if(!empty($foods)){
                $food_cats = ',' . implode(",", $foods) . ',';
            }
            $data['food_cats'] = $food_cats;
            
            $res = Menu::create($data);
            if($res){
                //save food category
               // $foods = $request->get('foods',[]);                
                $insertMenuFood = MenuFoodType::insertMenuFoodType($res->id, $foods);

                $request->session()->flash("success_message", "Menu is created.");

                return redirect()->route('menu_list',['id'=>$id]);
            }else{
                $request->session()->flash("fail_message", "Please try again!");
            }


            return redirect()->route('menu_edit', ['id'=>$res->id]);
        }        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function show($id)
    {
        $menu = Menu::findOrFail($id);
        return view('pro.menu.show', compact('$menu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function edit($id)
    {        
        $menu = Menu::with('foods')->where('id',$id)->first();
        
        $foodIds = [];
        if($menu && !empty($menu->foods)){
            foreach ($menu->foods as $food) {
                $foodIds[] = $food->id;
            }
        }
        
        $food_cats = FoodType::all();
        
        $categories = [];
        $categoriesObj = Category::all();
        if($categoriesObj){
            $catsArr = $categoriesObj->toArray ();
            foreach ($catsArr as $cat) {
                $categories[$cat['id']] = $cat['name'];
            }
        }        
        
        return view('pro.menu.edit', ['menu'=>$menu,'foodIds'=>$foodIds,'food_cats'=>$food_cats, 'categories'=>$categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function update($id, Request $request)
    {
        //$this->validate($request, $this->get_defined_valid_rule('edit'));        
        $menu = Menu::findOrFail($id);
        
        $data = $request->all();
        $data['price'] = $this->tofloat($data['price']);//str_replace([","," "],[".",""],preg_replace('/\s/', '', strval($data['price'])));
        $data['to_date'] = $data['from_date'];
        
        $validator = validator($data, $this->get_defined_valid_rule('edit',$data['from_date'],$menu->restaurant_id,$id));        

        if ($validator->fails()) {
            $request->session()->flash("fail_message", "Form invalid, Please try again!");
            return redirect()->route('menu_edit',['id'=>$id])
                        ->withErrors($validator)
                        ->withInput();
        }else{
            //save food category
            $food_cats = '';
            $foods = $request->get('foods',[]);  
            if(!empty($foods)){
                $food_cats = ',' . implode(",", $foods) . ',';
            }
            $data['food_cats'] = $food_cats;
             
            $res = $menu->update($data);

            if($res){
                //save food category
                //$foods = $request->get('foods',[]); 
                // delete old foods menu and insert new foods menu
                $deleteMenuFood = MenuFoodType::where('menu_id',$id)->delete();
                
                $insertMenuFood = MenuFoodType::insertMenuFoodType($id, $foods);
                
                $request->session()->flash("success_message", "Menu is updated.");
            }else{
                $request->session()->flash("fail_message", "Please try again!");
            }

            return redirect()->route('menu_list', ['id'=>$menu->restaurant_id]);
        }
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy(Request $request, $id)
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
            
            return redirect()->route('menu_list',['id'=>$restaurantId]);
        } else {
            return abort(404);
        }

        return redirect();
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
        
        
        return view('pro.menu.create_quick', $results);
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
                
                return redirect()->route('menu_add_quick');
            }
        }else{
            $restaurant = UltiFunc::getInitRestoDetail();
        }
        $food_cats = FoodType::all();
        
        return view('pro.menu.create_quick_step2', ['restaurant'=>$restaurant,'food_cats'=>$food_cats]);
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
                    'verify_status'=> Constant::VERIFIED_STATUS
                ];

                $restaurant = Restaurant::create($restaurant_data);

                if($restaurant instanceof Restaurant){
                    $restaurant_id = $restaurant->id;
                   // event(new ItemCreatedEvent($restaurant));   
                }
            }
            
            if(!empty($restaurant_id)){
                //save food category
                $food_cats = '';
                $foods = $request->get('foods',[]);  
                if(!empty($foods)){
                    $food_cats = ',' . implode(",", $foods) . ',';
                }
                $menu = Menu::create([
                        'name'=>$datas['name'],
                        'price'=>$this->tofloat($datas['price']),
                        'restaurant_id'=>$restaurant_id,
                        'category_id'=>2,
                        'from_date'=>date('Y-m-d',time()),
                        'to_date'=>date('Y-m-d',time()),
                        'food_cats'=>$food_cats,
                        ]);
                if($menu){
                    //save food category
                    //$foods = $request->get('foods',[]);                
                    $insertMenuFood = MenuFoodType::insertMenuFoodType($menu->id, $foods);
                    
                    $request->session()->flash("success_message", "Menu is created."); 
                    return redirect()->route('menu_add_quick_step2',['place_id'=>$restaurant_id]);
                }else{
                    $request->session()->flash("fail_message", "Please try again!");
                    
                    return redirect()->route('menu_add_quick_step2',['place_id'=>$request->get('place_id')]);
                }               
                //return redirect()->route('menu_add_quick');
            }
        }else{
            $request->session()->flash("fail_message", "Form is invalid!");
        }
        
        
        return redirect()->route('menu_add_quick_step2',['place_id'=>$request->get('place_id')]) ->withErrors($validator)
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
}
