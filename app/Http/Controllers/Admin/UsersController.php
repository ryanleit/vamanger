<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Session;
use App\User;
use App\Menu;
use App\Country;
use App\Restaurant;
use App\UserPackage;
use App\MenuFoodType;
use App\Models\Role;
use App\Helpers\ACLHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;

class UsersController extends Controller
{
    public $active_tab;
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->active_tab = 'user';
        View::share ( 'active_tab', $this->active_tab );
        View::share ( 'page', 'user' );      
    }
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index($order_by='id', $order_direct='asc')
    {
        if(ACLHelper::hasPermission('list_account')){
            $order_by         = Input::get('order_by')
                              ? Input::get('order_by')
                              : $order_by;

            $order_direct     = Input::get('order_direct')
                              ? Input::get('order_direct')
                              : $order_direct;

            $users = User::orderBy($order_by, $order_direct)->paginate(15);
            return view('admin.users.index', compact('users'))
                    ->with('order_by',      $order_by)
                    ->with('order_direct',  $order_direct);
        }else{
            abort(404, 'Access denied!');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        if(ACLHelper::hasPermission('create_account')){
            $roles = [];
            $rolesObj = Role::all()->toArray();
            if($rolesObj){
                foreach($rolesObj as $role){                    
                    $roles[$role['id']] = $role['name'];
                }
            }
            $countries = [];
            $countriesObj = Country::orderBy('nicename','asc')->get()->toArray();
            if($countriesObj){
                foreach($countriesObj as $country){                    
                    $countries[$country['id']] = $country['nicename'];
                }
            }
            
            return view('admin.users.create', compact('countries','roles'));
        }else{
            abort(404, 'Access denied!');
        }        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function store(Request $request)
    {
        if(ACLHelper::hasPermission('create_account')){
            $this->validate($request, ['name' => 'required', 'email' => 'required', 'password' => 'required', 'role_id' => 'required','type' => 'required', 'status' => 'required', ]);

            $data = $request->all();
            $data['password'] = bcrypt($data['password']);
            $user = User::create($data);
            if($user){
                Session::flash('success_message', 'User is added!');
            }else{
                Session::flash('fail_message', 'Please try again!');
            }
            return redirect('admin/users');
        }else{
            abort(404, 'Access denied!');
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
        if(ACLHelper::hasPermission('view_account')){
            $user = User::findOrFail($id);
            return view('admin.users.show', compact('user'));
        }else{
            abort(404, 'Access denied!');
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
        if(ACLHelper::hasPermission('update_account')){
            $user = User::findOrFail($id);
            $roles = [];
            $rolesObj = Role::all()->toArray();
            if($rolesObj){
                foreach($rolesObj as $role){                    
                    $roles[$role['id']] = $role['name'];
                }
            }
            $countries = [];
            $countriesObj = Country::orderBy('nicename','asc')->get()->toArray();
            if($countriesObj){
                foreach($countriesObj as $country){                    
                    $countries[$country['id']] = $country['nicename'];
                }
            }
            return view('admin.users.edit', compact('user','countries','roles'));
        }else{
            abort(404, 'Access denied!');
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
        try {
            if(ACLHelper::hasPermission('update_account')){               

                $user = User::findOrFail($id);
                if($user instanceof User){
                    $data = $request->all();                

                    $res = $user->update($data);                                

                    if($res){
                        if(!empty($request->get('password'))){                        

                            $user = User::findOrFail($id);
                            $user->password = bcrypt($request->get('password'));
                            $user->save();
                            
                        }
                        Session::flash('success_message', 'User is updated!');
                        return redirect('admin/users');
                    }else{
                        Session::flash('fail_message', 'Something went wrong! Please try again.');
                    }               
                }else{
                    Session::flash('fail_message', 'User is not found!');
                }
            }else{
                abort(404, 'Access denied!');
            }
            
        } catch (Exception $exc) {
            Session::flash('fail_message', $exc->getTraceAsString());
        }

        return redirect('/admin/users/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return void
     */
    public function destroy(Request $request, $id,$type = 'soft')
    {
        if(ACLHelper::hasPermission('delete_account')){
            try {
                $user = User::find($id);
                
                if($user instanceof User){
                    
                    $restaurants = Restaurant::withTrashed()->where('user_id',$id)->get();
                    
                    if(count($restaurants) > 0){
                        if($type == 'force'){                    
                            foreach ($restaurants as $restaurant) {
                                $menus = Menu::withTrashed()->where('restaurant_id',$restaurant->id)->get();
                                if(count($menus) >0){ 
                                    $menusArr = $menus->toArray();
                                    $ids_to_delete = array_map(function($menu){ return $menu['id']; }, $menusArr);
                                    $del_menu_cate = MenuFoodType::whereIn('menu_id',$ids_to_delete)->forceDelete();
                                                      
                                    $menus = Menu::withTrashed()->where('restaurant_id',$restaurant->id)->forceDelete();
                                }
                                $restaurant->forceDelete();
                            }                                                        

                            $userPackage = UserPackage::withTrashed()->where('user_id',$id)->forceDelete();                            
                           
                        }else{
                            foreach ($restaurants as $restaurant) {
                                $delMenus = Menu::where('restaurant_id',$restaurant->id)->delete();
                                
                                $restaurant->delete();
                            }                            

                            $delUserPackage = UserPackage::where('user_id',$id)->delete();                            
                        }
                    }
                    
                    $del_account = ($type == 'force')?$user->forceDelete():$user->delete();
                    
                    Session::flash('success_message', 'User is deleted!');
                }else{
                    Session::flash('fail_message', 'User is not found!');
                }              
            } catch (Exception $exc) {
                Session::flash('fail_message', 'Fail! '.$exc->getTraceAsString());
            }
            
            return redirect('admin/users');
            
        }else{
            abort(404, 'Access denied!');
        } 
    }
}
