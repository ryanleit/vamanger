<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\View;
use App\FoodType;
//use App\Restaurant;
//use App\Category;
use App\MenuFoodType;
use Illuminate\Http\Request;
//use Carbon\Carbon;
//use Session;
use Illuminate\Support\Facades\Input;

class DishController extends Controller
{
    public $active_tab;
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->active_tab = 'dish';
        View::share ( 'active_tab', $this->active_tab );
        View::share ( 'page', 'dish' );   
    }
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index($order_by='id', $order_direct='asc')
    {
       
        $order_by         = Input::get('order_by')
                          ? Input::get('order_by')
                          : $order_by;

        $order_direct     = Input::get('order_direct')
                          ? Input::get('order_direct')
                          : $order_direct;

        
        $foods = FoodType::orderBy($order_by, $order_direct)->paginate(30);
                
        return view('admin.dish.index', ['foods'=>$foods])
                ->with('order_by',      $order_by)
                ->with('order_direct',  $order_direct);
    }
    /**
     * 
     * @return string
     */
    public static function get_defined_valid_rule($type) {
        
        $rules = ['name' => 'required|max:191',
                'description' => 'max:500',
                ];
        
        return $rules;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {                         
        
        return view('admin.dish.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->get_defined_valid_rule('add'));
        $data = $request->all();
        $res = FoodType::create($data);
        if($res){
            
            $request->session()->flash("success_message", "Dish is created.");
            
            return redirect()->route('dish_list');
        }else{
            $request->session()->flash("fail_message", "Please try again!");
        }
        

        return redirect()->route('dish_add');
        
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
        $food = FoodType::where('id',$id)->first();
        
        if($food){        
            return view('admin.dish.edit', ['food'=>$food]);
        }else{
            return abort(404);
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
        $this->validate($request, $this->get_defined_valid_rule('edit'));
        
        $food = FoodType::findOrFail($id);
        
        if($food){
            
            $res = $food->update($request->all());

            if($res){            
                $request->session()->flash("success_message", "Dish is updated.");
            }else{
                $request->session()->flash("fail_message", "Please try again!");
            }        
        }else{
                $request->session()->flash("fail_message", "Dish is not found!");
        }
        return redirect()->route('dish_list');
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
        $food = FoodType::find($id);
        if($food){
            $delMenuFood = MenuFoodType::where('food_type_id',$id)->forceDelete();
            $del = $food->forceDelete();   
            if($del){
                $request->session()->flash("success_message", "Dish is deleted.");                
            }else{
                $request->session()->flash("fail_message", "Please try again!");
            }
            
            return redirect()->route('dish_list');
            
        } else {
            return abort(404);
        }

       return redirect()->route('dish_list');
    }       
}
