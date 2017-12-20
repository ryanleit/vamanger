<?php

namespace App\Http\Controllers\Admin;


//use Carbon\Carbon;
use App\User;
use App\Menu;
use App\Restaurant;
use App\MenuFoodType;
use App\ItemCategory;
use App\Ultility\Constant;
use App\Helpers\ACLHelper;
use Illuminate\Http\Request;
use App\Mail\RestaurantEmail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

use Illuminate\Support\Facades\Input;
use App\Events\ItemCreatedEvent;

class RestaurantController extends Controller
{
    public $active_tab;
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->active_tab = 'restaurant';
        View::share ( 'active_tab', $this->active_tab );
        View::share ( 'page', 'restaurant' );       
    }
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index(Request $request, $order_by='updated_at', $order_direct='desc', $status='all')
    {
        
        if(ACLHelper::hasPermission('list_item')){
            $order_by         = Input::get('order_by')
                              ? Input::get('order_by')
                              : $order_by;

            $order_direct     = Input::get('order_direct')
                              ? Input::get('order_direct')
                              : $order_direct;

            $status = $request->get('status');
            
            if(empty($status)){
                $query = Restaurant::with('menus')->orderBy($order_by, $order_direct);
            }else{
                if($status == 'trashed'){
                    $query = Restaurant::with('menus')->onlyTrashed()->orderBy($order_by, $order_direct);
                }else{
                    $query = Restaurant::with('menus')->where('verify_status', '=', $status)->orderBy($order_by, $order_direct);
                }
            }
            
            $search = $request->get('search');
            
            if(!empty($search)){                
                $query = $query->where(function($query) use ($search){
                    $query->where('restaurants.name', 'LIKE', "%".$search."%");
                    $query->orWhere('restaurants.address', 'LIKE', "%".$search."%");
                    $query->orWhere('restaurants.id',  'LIKE', "%".$search."%");
                    $query->orWhere('restaurants.phone',  'LIKE', "%".$search."%");
                 });
            }
            
            $restaurants = $query->paginate(30);
            
            return view('admin.restaurant.index', compact('restaurants'))
                    ->with('order_by',      $order_by)
                    ->with('order_direct',  $order_direct)
                    ->with('status',  $status)
                    ->with('search',  $search);
        }else{
            abort(404, "Access denied!");
        }
    }
    /**
     * 
     * @return string
     */
    public static function get_defined_valid_rule($request, $id=NULL) {
        
        $rules = [
                    'address' => 'required|max:191',
                    'year'=>'digits_between:0,9999,min:1|max:4',
                    'legal_effectif_min'=>'nullable|integer',
                    'legal_effectif_max'=>'nullable|integer',                    
                    'type_id' =>'integer',
                    'lat' => 'required',
                    'lng' => 'required',
                    'status'=>'in:active,inactive',
                    'verify_status'=>'in:pending,verified,closed',
                ];
        $rules['phone'] =  'required|max:20|regex:/^[\+]{1}[0-9]{9,15}$/';
        
        $phone = $request->get('phone');
        $name = $request->get('name');
        if(!empty($phone) && !empty($name)){
            $resto_id = (empty($id))?'0':$id;
            $rules['name'] =  'required|max:191|unique_restaurant:'.$phone.','.$resto_id;
        }else{
            $rules['name'] =  'required|max:191';
        }
        
        /*if(empty($id)){
            $rules['phone'] =  'required|max:20|unique:restaurants,phone';
        }else{
            $rules['phone'] =  'required|max:20|unique:restaurants,phone,'.$id.',id';
        }*/
        return $rules;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {   
        if(ACLHelper::hasPermission('create_item')){
            
            if(User::hasRoleLevel(6)){
                $restaurant_id = $this->checkRestoOwnerExist();
                if($restaurant_id) 
                    return redirect()->route('my_restaurant_edit',['id'=>$restaurant_id]);
            }  
            
            $item_cats = ItemCategory::getItemCategories();
            return view('admin.restaurant.create', ['restaurant_cats'=>$item_cats]);
        }else{
            abort(404, "Access denied!");
        }
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function store(Request $request)
    {
        if(ACLHelper::hasPermission('create_item')){
            if(User::hasRoleLevel([6])){
                $restaurant_id = $this->checkRestoOwnerExist();
                if($restaurant_id) 
                    return redirect()->route('my_restaurant_edit',['id'=>$restaurant_id]);
            }else{
                $force_add = $request->get('force_option');
                if($force_add != 'yes'){
                    $restaurant_id = $this->getRestaurantByPhone($request);
                    $request->session()->flash("merge_message", 'There has one restaurant with the same phone!');
                    return redirect()->route('restaurant_add',['mer_id'=>$restaurant_id])->withInput();
                }
            }            
                
            $validator = validator($request->all(), $this->get_defined_valid_rule($request,NULL));
            //$this->validate($request, $this->get_defined_valid_rule('add'));
            if ($validator->fails()) {                
                $request->session()->flash("fail_message", "Form invalid, Please try again!");
                return redirect()->route('restaurant_add')
                            ->withErrors($validator)
                            ->withInput();
            }else{
                $restaurant_data = $request->all();

                $restaurant_data['user_id'] = (auth()->id())?auth()->id(): 2;

                $restaurant = Restaurant::create($restaurant_data);

                if($restaurant instanceof Restaurant){
                    
                    if(User::hasRole(Constant::MANAGER_ROLE)){
                        event(new ItemCreatedEvent($restaurant,new Menu()));
                    }                       
                    
                    $request->session()->flash("success_message", "Restaurant is created.");
                    
                    if(User::hasRoleLevel([12,9]))
                        return redirect('admin/restaurants');
                    else 
                        return redirect()->route('my_restaurant_edit',['id'=>$restaurant->id]);
                }else{
                    $request->session()->flash("fail_message", "Please try again!");
                    
                }
                if(User::hasRoleLevel([12,9]))
                    return redirect()->route('restaurant_add');
                else 
                    return redirect()->route('my_restaurant_add');
            }
        }else{
            abort(404, "Access denied!");
        }
    }
    /**
     * 
     * @return type
     */
    public function checkRestoOwnerExist() {
        $restaurant = Restaurant::where('user_id', auth()->id())->first();
        
        if($restaurant)
            return $restaurant->id;
        
        return null;
    }
    /**
     * 
     * @return type
     */
    public function getRestaurantByPhone($res) {
        $phone = $res->get('phone');
        
        if(!empty($phone)){
            $restaurant = Restaurant::where('phone', $phone)->first();
            if($restaurant)
                return $restaurant->id;
        }
        
        return FALSE;
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
        if(ACLHelper::hasPermission('view_item')){
            $restaurant = Restaurant::findOrFail($id);
            return view('admin.restaurant.show', compact('restaurant'));
        }else{
            abort(404, "Access denied!");
        }
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
        if(ACLHelper::hasPermission('update_item')){
            $restaurant = Restaurant::withTrashed()->find($id);
               
            $item_cats = ItemCategory::getItemCategories();
            return view('admin.restaurant.edit', ['page'=>'res-detail','restaurant'=>$restaurant,'restaurant_cats'=>$item_cats]);
        }else{
            abort(404, "Access denied!");
        }
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
        if(ACLHelper::hasPermission('update_item')){
            $validator = validator($request->all(), $this->get_defined_valid_rule($request,$id));        

            if ($validator->fails()) {
                $request->session()->flash("fail_message", "Form invalid, Please try again!");
                return redirect()->route('restaurant_edit',['id'=>$id])
                            ->withErrors($validator)
                            ->withInput();
            }else{
                $restaurant = Restaurant::withTrashed()->find($id);
                
                $old_status = $restaurant->verify_status;
                
                $resto = $restaurant->update($request->all());
                
                if($resto){
                    if($old_status != $restaurant->verify_status){
                        $userinfo = User::find($restaurant->user_id);
                        if($userinfo && $restaurant->verify_status == Constant::VERIFIED_STATUS){                            
                            Mail::to($userinfo->email)->send(new RestaurantEmail($restaurant,NULL,[],'item_verified'));    
                        }elseif($userinfo && $restaurant->verify_status == Constant::CLOSED_STATUS){
                            Mail::to($userinfo->email)->send(new RestaurantEmail($restaurant,NULL,[],'item_closed'));    
                        }
                    }
                    
                    //event(new ItemCreatedEvent($restaurant));  
                    $request->session()->flash("success_message", "Restaurant is updated.");
                }else{
                    $request->session()->flash("fail_message", "Please try again!");
                }

                return redirect('admin/restaurants');
            }
        }else{
            abort(404, "Access denied!");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy($id, Request $request)
    {
        if(ACLHelper::hasPermission('delete_item')){
            $retaurant = Restaurant::withTrashed()->where('id',$id)->first();
            if ($retaurant->trashed()) {
                 // Force deleting all related models...
                $menus = Menu::withTrashed()->where('restaurant_id',$id)->get();
                if(count($menus) >0){
                    $menusArr = $menus->toArray();
                    $ids_to_delete = array_map(function($menu){ return $menu['id']; }, $menusArr);
                    $del_menu_cate = MenuFoodType::whereIn('menu_id',$ids_to_delete)->forceDelete();

                    $menus = Menu::withTrashed()->where('restaurant_id',$id)->forceDelete();
                }
                // $retaurant->menus()->forceDelete();
                $del = $retaurant->forceDelete();
            }else{ 
                $retaurant->menus()->delete();
                $del = Restaurant::destroy($id);              
            }
            if($del){
                $request->session()->flash("success_message", "Restaurant is deleted.");
            }else{
                $request->session()->flash("fail_message", "Please try again!");
            }
            if(\App\User::hasRoleLevel([9,12])){
                return redirect('admin/restaurants');
            }else{
                return redirect('admin/my-restaurant/add');
            }
        }else{
            abort(404, "Access denied!");
        }
    } 
     /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function ownerRestaurant($order_by='updated_at', $order_direct='desc')
    {
        
        $order_by         = Input::get('order_by')
                          ? Input::get('order_by')
                          : $order_by;

        $order_direct     = Input::get('order_direct')
                          ? Input::get('order_direct')
                          : $order_direct;

        $user_id = auth()->id();
        
        $restaurants = Restaurant::with('menus')->where('user_id',$user_id)->orderBy($order_by, $order_direct)->paginate(30);
        return view('pro.my_restaurant.index', compact('restaurants'))
                ->with('order_by',      $order_by)
                ->with('order_direct',  $order_direct);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function myRestaurantEdit(Request $request, $id)
    {
        $userId = auth()->id();        
        
        $restaurant = Restaurant::where('id',$id)->where('user_id',$userId)->first();
        if($restaurant){
            $item_cats = ItemCategory::getItemCategories();
            
            return view('admin.restaurant.edit', ['page'=>'res-detail','restaurant'=>$restaurant,'restaurant_cats'=>$item_cats]);
        }else{
            $request->session()->flash("fail_message", "Restaurant is not found!");
        }
        
        return redirect()->route('pro_dashboard');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function myRestaurantUpdate(Request $request,$id)
    {
        //$this->validate($request, $this->get_defined_valid_rule('edit'));
        
        $user_id = auth()->id();
        
        $restaurant = Restaurant::where('id',$id)->where('user_id',$user_id)->first();
        
        if($restaurant){
            $validator = validator($request->all(), $this->get_defined_valid_rule($request,$id));        

            if ($validator->fails()) {
                $request->session()->flash("fail_message", "Form invalid, Please try again!");
                return redirect()->route('my_restaurant_edit',['id'=>$id])
                            ->withErrors($validator)
                            ->withInput();
            }else{
                $userId = auth()->id();
                $res = $restaurant->update($request->all());

                if($res){
                    $request->session()->flash("success_message", "Restaurant is updated.");
                }else{
                    $request->session()->flash("fail_message", "Please try again!");
                }

                return redirect()->route('my_restaurant_edit', ['id' => $id]);
            }
        }else{
            $request->session()->flash("fail_message", "Restaurant is not found!");
        }
        
        return redirect()->route('pro_dashboard');
    }
    
    public function ajaxCurrency($country_code) {
        
        $code = strtoupper($country_code);
        $currency = country()->currency($code);
        
        return response()->json(array('status' => 'ok','data'=>$currency));  
    }
}
