<?php

namespace App\Http\Controllers\Api;
use App\FoodType;
use App\Ultility\Constant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FoodTypeApiController extends Controller
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
    public function foodList(Request $request)
    {                     
        
        $data = ['status'=>'ok','data'=>[],'message'=>''];
                
        $page = (empty($request->get("page")))?1:intval($request->get("page"));
        $per_page = (empty($request->get("per_page")))?50:intval($request->get("per_page"));
        
        $foodsObj = FoodType::paginate($per_page);
        
        if($foodsObj){
            $foods = $foodsObj->toArray();
            
            $data = ['status'=>'ok','data'=>$foods,'message'=>''];
        }else{
            $data['message'] = 'Data not found!';
        }
        return response()->json($data, 200);        
    }     
}
