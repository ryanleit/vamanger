<?php

namespace App;

use App\FoodType;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class MenuFoodType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'menus_food_types';


    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['menu_id', 'food_id'];
    
    /**
     * 
     * @param type $menu_id
     * @param type $data
     * @return boolean
     */
    public static function insertMenuFoodType($menu_id,$data) {
        //save food category
        $foods = (is_array($data))?$data:[];
        if($foods){
            // valid food ids
            $food_arr = [];
            $food_cats = FoodType::select('id')->get();                
            if($food_cats){
                foreach ($food_cats as $food) {
                    $food_arr[] = $food->id;
                }
            }

            $foodsOfMenuIds = array_intersect($foods,$food_arr);
            
            if(count($foodsOfMenuIds) > 0){
                $foodsMenusArr = [];
                foreach ($foodsOfMenuIds as $foodId) {
                    $foodsMenusArr[] = ['menu_id'=>$menu_id,'food_type_id'=>$foodId,'created_at'=>date('Y-m-d H:i:s')];
                }
                
                $insertMenuFood = self::insert($foodsMenusArr);

                return $insertMenuFood;
            }
        }
        
        return false;
    }
}
