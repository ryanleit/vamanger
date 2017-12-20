<?php

namespace App\Http\Controllers\Admin;

use App\Menu;
use App\User;
use App\Restaurant;
use App\UserExperience;

use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;

class DashboardController extends Controller
{
    public $active_tab;
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->active_tab = 'dashboard';
        View::share ( 'active_tab', $this->active_tab );
    }
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {      
        $prouser_count = User::where('role_id',3)->count();
        $normaluser_count = User::where('role_id',4)->count();
        
        $statistics_regis = [];
        $current_year = date('Y');
        $users_register = User::select(DB::raw('count(id) as user_count, created_at'))->where('role_id',3)->where(DB::raw('YEAR(created_at)'),$current_year)->groupBy(DB::raw('MONTH(created_at)'))->get()->toArray();
        if(count($users_register) > 0 ){
            foreach($users_register as $user_regis){
                $statistics_regis[date('F', strtotime($user_regis['created_at']))] = $user_regis['user_count'];
            }
        }
        /*Normal user*/
        $statistics_regis_normal = [];
        
        $users_register_normal = User::select(DB::raw('count(id) as user_count, created_at'))->where('role_id',4)->where(DB::raw('YEAR(created_at)'),$current_year)->groupBy(DB::raw('MONTH(created_at)'))->get()->toArray();
        if(count($users_register_normal) > 0 ){
            foreach($users_register_normal as $users_normal){
                $statistics_regis_normal[date('F', strtotime($user_regis['created_at']))] = $user_regis['user_count'];
            }
        }
        
        $statistics_resto = [];
        $restaurants = User::select(DB::raw('count(status) as status_count, status'))->groupBy('status')->get()->toArray();
        if(count($restaurants) > 0 ){
           
            foreach($restaurants as $restaurant){
                $statistics_resto[$restaurant['status']] = $restaurant['status_count'];
            }
        }

        $now = date('Y-m-d');
        $dish_today_count = Menu::select('*')
                            ->leftJoin('restaurants','menus.restaurant_id', '=',  'restaurants.id')                            
                            ->where('menus.from_date','<=',$now)
                            ->where('menus.to_date','>=',$now)
                            ->count();
       
        //My code 
        $restaurant_count = Restaurant::count();
        $newRestaurant = [];
        $currMonth = date('Y').'-'.date('m');
        foreach ($this->getDateInMonth(date('m'), date('Y')) as $date) {
            $item['count'] = Restaurant::whereDate('created_at', date('Y-m-d', strtotime($currMonth.'-'.$date)))->count();
            $item['date'] = (int)$date;
            $newRestaurant[] = $item;
        }
        $newRestaurant = json_encode($newRestaurant);

        $newProuser = [];
        foreach ($this->getDateInMonth(date('m'), date('Y')) as $date) {
            $item['count'] = User::where('role_id', 3)->whereDate('created_at', date('Y-m-d', strtotime($currMonth.'-'.$date)))->count();
            $item['date'] = (int)$date;
            $newProuser[] = $item;
        }

        $newProuser = json_encode($newProuser);

        $newNormaluser = [];
        foreach ($this->getDateInMonth(date('m'), date('Y')) as $date) {
            $item['count'] = User::where('role_id', 4)->whereDate('created_at', date('Y-m-d', strtotime($currMonth.'-'.$date)))->count();
            $item['date'] = (int)$date;
            $newNormaluser[] = $item;
        }

        $newNormaluser = json_encode($newNormaluser);

        $newDishes = [];
        foreach ($this->getDateInMonth(date('m'), date('Y')) as $date) {
            $item['count'] = Menu::select('*')
                            ->leftJoin('restaurants','menus.restaurant_id', '=',  'restaurants.id')
                            ->where('menus.from_date','<=', date('Y-m-d', strtotime($currMonth.'-'.$date)))
                            ->where('menus.to_date','>=', date('Y-m-d', strtotime($currMonth.'-'.$date)))
                            ->count();
            $item['date'] = (int)$date;
            $newDishes[] = $item;
        }

        $newDishes = json_encode($newDishes);

        return view('admin.dashboard.index',['restaurant_count'=>$restaurant_count,
                                                    'prouser_count'=>$prouser_count,
                                                    'normaluser_count'=>$normaluser_count,
                                                    'dish_today_count'=>$dish_today_count,
                                                    'statistics_regis'=>$statistics_regis,
                                                    'statistics_regis_normal'=>$statistics_regis_normal,
                                                    'statistics_resto'=>$statistics_resto,
                                                    'active_tab'=>'dashboard','page'=>'dashboard',
                                                    'newRestaurant' => $newRestaurant,
                                                    'newProuser' => $newProuser,
                                                    'newNormaluser'=> $newNormaluser,
                                                    'newDishes' => $newDishes]);    
    }
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function dashboard()
    {               
        
        //$restaurant_count = Restaurant::where('user_id', auth()->id())->count();
        
        $total_view = Restaurant::select( DB::raw('SUM(view_count) as total_count'))
                                    ->where('user_id',auth()->id())
                                    ->first();
        
        $menus_count = Menu::select('*')
                            ->leftJoin('restaurants','menus.restaurant_id', '=',  'restaurants.id')
                            ->where('restaurants.user_id',auth()->id())
                            ->count();
        
        $now = date('Y-m-d',time());
        $dish_today_count = Menu::select('*')
                            ->leftJoin('restaurants','menus.restaurant_id', '=',  'restaurants.id')
                            ->where('restaurants.user_id',auth()->id())
                            ->where('user_id',auth()->id())
                            ->where('menus.from_date','=',$now)
                            ->where('menus.to_date','=',$now)
                            ->count();
        
        return view('admin.dashboard.pro_dashboard',[//'restaurant_count'=>$restaurant_count,
                                                    'total_view'=>$total_view->total_count,
                                                    'menu_count'=>$menus_count,
                                                    'dish_today_count'=>$dish_today_count,
                                                    'active_tab'=>'dashboard','page'=>'dashboard']);
    }
    /**
     * 
     * @param type $order_by
     * @param type $order_direct
     * @return type
     */
    public function userexp_list($order_by='id', $order_direct='asc')
    {
       
        $order_by         = Input::get('order_by')
                          ? Input::get('order_by')
                          : $order_by;

        $order_direct     = Input::get('order_direct')
                          ? Input::get('order_direct')
                          : $order_direct;

        $like_count = UserExperience::where('page','dish_add')->where('like','yes')->count();
        $dislike_count = UserExperience::where('page','dish_add')->where('like','no')->count();
        $userExps = UserExperience::select(['user_experiences.*','users.name'])->orderBy($order_by, $order_direct)
                    ->leftJoin('users','user_experiences.user_id', '=',  'users.id')
                    ->paginate(30);
                
        return view('admin.dashboard.userexp_list', ['userExps'=>$userExps,'like_count'=>$like_count,'dislike_count'=>$dislike_count])
                ->with('order_by',      $order_by)
                ->with('order_direct',  $order_direct);
    }

    public function ajaxChartData(){
        if(request()->expectsJson()){
            $type = request()->data_type;
            $month = request()->month;
            $currMonth = date('Y').'-'.$month;
            $dataRes = [];
            switch ($type) {
                case 'restaurant':
                    foreach ($this->getDateInMonth($month, date('Y')) as $date) {
                        $item['count'] = Restaurant::whereDate('created_at', date('Y-m-d', strtotime($currMonth.'-'.$date)))->count();
                        $item['date'] = (int)$date;
                        $dataRes[] = $item;
                    }

                    break;
                case 'pro-user':
                    foreach ($this->getDateInMonth($month, date('Y')) as $date) {
                        $item['count'] = User::where('role_id', 3)->whereDate('created_at', date('Y-m-d', strtotime($currMonth.'-'.$date)))->count();
                        $item['date'] = (int)$date;
                        $dataRes[] = $item;
                    }
                    break;
                case 'normal-user':
                    foreach ($this->getDateInMonth($month, date('Y')) as $date) {
                        $item['count'] = User::where('role_id', 4)->whereDate('created_at', date('Y-m-d', strtotime($currMonth.'-'.$date)))->count();
                        $item['date'] = (int)$date;
                        $dataRes[] = $item;
                    }
                    break;
                case 'dishes':
                    foreach ($this->getDateInMonth($month, date('Y')) as $date) {
                        $item['count'] = Menu::select('*')
                                        ->leftJoin('restaurants','menus.restaurant_id', '=',  'restaurants.id')
                                        ->where('menus.from_date','<=', date('Y-m-d', strtotime($currMonth.'-'.$date)))
                                        ->where('menus.to_date','>=', date('Y-m-d', strtotime($currMonth.'-'.$date)))
                                        ->count();
                        $item['date'] = (int)$date;
                        $dataRes[] = $item;
                    }
                    break;
                default:
                    $item['count'] = 0;
                    $item['date'] = 'Empty';
                    break;
            }

            return json_encode($dataRes);
        }
    }

    public function getDateInMonth($month, $year){
        $list=array();

        for($d=1; $d<=31; $d++)
        {
            $time=mktime(12, 0, 0, $month, $d, $year);          
            if (date('m', $time)==$month)       
                $list[]= date('d', $time);
        }
        return $list;
    }
}
