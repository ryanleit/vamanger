<?php

namespace App;

use App\Menu;
use App\Ultility\Constant;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'restaurants';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'address', 'currency','phone', 'email','code_postal','ville','siren','siren','ape','year','ca','resultat','effectif','legal_naf','legal_siret','legal_effectif_min','legal_effectif_max', 'description', 'user_id','type_id', 'lat', 'lng', 'slug','google_id', 'status', 'verify_status'];
    
    /**
     * Always capitalize the lat when we retrieve it
     */
    public function getLatAttribute($value) {
        
        return $value;
    }

    /**
     * Always capitalize the lng name when we retrieve it
     */
    public function getLngAttribute($value) {
        return $value;
    }
    /**
     * Always capitalize the lat when we save it to the database
     */
    public function setLatAttribute($value) {
        $this->attributes['lat'] = trim($value);
    }

    /**
     * Always capitalize the lng when we save it to the database
     */
    public function setLngAttribute($value) {
        $this->attributes['lng'] = trim($value);
    }
   
    public $foods;
    /**
     * Get the type record associated with the item.
     */
    public function user()
    {
        return $this->belongTo('App\User','id');
    }
     /**
     * Get the type record associated with the item.
     */
    public function type()
    {
        return $this->hasOne('App\ItemCategory','id');
    }
     /**
     * Get the type record associated with the item.
     */
    public function menus()
    {
        return $this->hasMany('App\Menu','restaurant_id');
    }
    /**
     * 
     * @param type $lat
     * @param type $lng
     * @return type
     */
    public static function getAllDishNearbyLimit($lat, $lng, $params, $uri = '/'){            
        $page = request('page',1);
        $per_page = request('per_page',20);
        $paginator = [];
        $offset = ($page-1) * $per_page;
        $total = 5;//self::getTotalDishToday($params);
        if($total > 0 ){
            $now = date('Y-m-d',time());
            DB::beginTransaction();
            DB::select(DB::raw('SET @rank :=0;'));
            DB::select(DB::raw('SET @group1 :=0;'));
            $arr_items = DB::select(
                self::getRawSql($params) . "limit ?,? ",
                [$lat, $lng, $lat,$now,$now,intval($offset),intval($per_page)]);
            DB::commit();
            if($arr_items){                          
                $paginator = new LengthAwarePaginator($arr_items,$total,$per_page,$page,['path'=>$uri]);

                foreach ($paginator as $key => $value) {
                    $data = (array) $value;
                    $foodsObj = MenuFoodType::select(['food_types.id','food_types.name'])
                            ->leftJoin('food_types', 'menus_food_types.food_type_id', '=', 'food_types.id')
                            ->where('menus_food_types.menu_id',$data['menu_id'])
                            ->groupBy('food_types.id')
                            ->get();  
                    $paginator[$key]->foods = $foodsObj;              
                }            
            }
        }//var_dump($params);exit;
        return $paginator;
    }
     /**
     * 
     * @param type $lat
     * @param type $lng
     * @return type
     */
    public static function getRawSql($params){
        
        $sql = "select * from ( " . self::buildSelectSql($params) . ") as dish where rank <=2";
        
        $sql .= " order by distance asc ";
        
        return $sql;
    }
    public static function buildSelectSql($params) {
        $sql = "select `menus`.`id` as `menu_id`, `menus`.`restaurant_id`,
                    @rank := IF(@group1= `menus`.`restaurant_id`, @rank+1, 1) as rank,
                    @group1 := `restaurants`.`id` as group1,
                    ( 6371 * acos( cos( radians(?) ) *
                    cos( radians( lat ) )
                    * cos( radians( lng ) - radians(?)
                    ) + sin( radians(?) ) *
                    sin( radians( lat ) ) )) AS distance,
                `menus`.`name` as `menu_name`, `menus`.`description` as `menu_des`, `menus`.`price`,
                `restaurants`.id, `restaurants`.`name`,`restaurants`.`address`,`restaurants`.`lat`,`restaurants`.`lng`,`restaurants`.`user_id`
                from `menus`";
        
        $sql .= " left join `restaurants` on `menus`.`restaurant_id` = `restaurants`.`id`";
        
        $sql .= " where `menus`.`from_date` = ?
                        and `menus`.`to_date` = ? 
                        and `menus`.`status` = 'active' 
                        and `restaurants`.`verify_status` = 'verified' 
                        and `restaurants`.`deleted_at` is null 
                        and `menus`.`deleted_at` is null";
        
        if(!empty($params['restaurant_name'])){
            $sql .= " and `restaurants`.`name` LIKE '%" .$params['restaurant_name']. "%'";
        }
          if(!empty($params['dish_name'])){
            $sql .= " and `menus`.`name` LIKE '%" .$params['dish_name']. "%'";
        }
        if(!empty($params['foods'])){
            $query_like = array();
            foreach ($params['foods'] as $food) {
                $query_like[] = "`menus`.`food_cats` LIKE '%," . $food . ",%'";
            }
            $sql .= " and (". implode(" or ", $query_like) . ")";
        }
        
        return $sql;
    }
    /**
     * 
     */
    public static function getTotalDishToday($params){
        
        $sql = "select count(*) as total from (
                select `menus`.`id` as `menu_id`, `menus`.`restaurant_id`,
                    @rank := IF(@group= `menus`.`restaurant_id`, @rank+1, 1) as rank,
                    @group := `restaurants`.`id`,

                `menus`.`name` as `menu_name`, `menus`.`description` as `menu_des`, `menus`.`price`,
                `restaurants`.id, `restaurants`.`name`,`restaurants`.`address`,`restaurants`.`lat`,`restaurants`.`lng`,`restaurants`.`user_id`
                from `menus` 
                left join `restaurants` on `menus`.`restaurant_id` = `restaurants`.`id`
                where  `menus`.`from_date` = ?
                        and `menus`.`to_date` = ?
                        and `menus`.`status` = 'active' 
                        and `restaurants`.`verify_status` = 'verified' 
                        and `restaurants`.`deleted_at` is null 
                        and `menus`.`deleted_at` is null";
        
         if(!empty($params['restaurant_name'])){
            $sql .= " and `restaurants`.`name` LIKE '%" .$params['restaurant_name']. "%'";
        }
          if(!empty($params['dish_name'])){
            $sql .= " and `menus`.`name` LIKE '%" .$params['dish_name']. "%'";
        }
        if(!empty($params['foods'])){
            $query_like = array();
            foreach ($params['foods'] as $food) {
                $query_like[] = "`menus`.`food_cats` LIKE '%," . $food . ",%'";
            }
            $sql .= " and (". implode(" or ", $query_like) . ")";
        }
        
        $sql .= ") as dish where rank <= 2;";
        $now = date('Y-m-d',time());
        DB::raw('SET @rank :=0;SET @group :=0;');
        
        $items = DB::select($sql,[$now,$now]);
      
       return $items[0]->total;               
    }
    /**
     * 
     * @param type $lat
     * @param type $lng
     * @return type
     */
    public static function getAllDishNearby($lat, $lng,$text=null){
        
        //$circle_radius = 3959;distance by miles, 6371 by kilometers with('foods')->
        DB::raw('SET @rank :=0;SET @group :=0;');
        $query = Menu::select(['menus.id as menu_id','menus.restaurant_id','menus.name as menu_name','menus.description as menu_des','menus.price','restaurants.*'])
                                ->leftJoin('restaurants', 'menus.restaurant_id', '=', 'restaurants.id');   
        if(!empty($lat) && !empty($lng)){
            $query = $query->selectRaw('( 6371 * acos( cos( radians(?) ) *
                                            cos( radians( lat ) )
                                            * cos( radians( lng ) - radians(?)
                                            ) + sin( radians(?) ) *
                                            sin( radians( lat ) ) )
                                        ) AS distance', [$lat, $lng, $lat])
                    ->orderBy('distance','ASC');
        }        
       /* if(!empty($text)){
            $query = $query->where(function($query) use ($text){
                $query->where('restaurants.name', 'LIKE', "%".$text."%");
                $query->orWhere('restaurants.address', 'LIKE', "%".$text."%");
                $query->orWhere('restaurants.description',  'LIKE', "%".$text."%");
                $query->orWhere('menus.name',  'LIKE', "%".$text."%");
             });
        }*/
        $now = date('Y-m-d',time());
        $query = $query->where(function($query) use($now){
                $query->where('menus.from_date','=',$now);
                $query->where('menus.to_date','=',$now);
        });
        //$items = $query->paginate(30);
        
        $items = $query->where('menus.status', Constant::ACTIVE_STATUS)
                ->where('restaurants.verify_status', Constant::VERIFIED_STATUS)
                ->where('restaurants.deleted_at',NULL)               
                ->paginate(30);
        
         if($items){
            $arr_items = $items->toArray();
            
            foreach ($arr_items['data'] as $key => $value) {
                $foodsObj = MenuFoodType::select(['food_types.id','food_types.name'])
                        ->leftJoin('food_types', 'menus_food_types.food_type_id', '=', 'food_types.id')
                        ->where('menus_food_types.menu_id',$value['menu_id'])
                        ->groupBy('food_types.id')
                        ->get();   
                if($foodsObj){                    
                    $items[$key]->foods = $foodsObj;
                }
                
            }            
        }
        return $items;
    }
    /**
     * 
     * @param type $lat
     * @param type $lng
     * @return type
     */
    public static function getRestaurantsSearch($text, $lat, $lng){
        
        //$circle_radius = 3959;
        //$max_distance = 100;
        
        $query = Restaurant::with('menus')->select(['restaurants.*','menus.restaurant_id','menus.name as menu_name','menus.price'])
                            ->leftJoin('menus','restaurants.id', '=',  'menus.restaurant_id');   
        if(!empty($lat) && !empty($lng)){
            $query = $query ->selectRaw('( 6371 * acos( cos( radians(?) ) *
                                            cos( radians( restaurants.lat ) )
                                            * cos( radians( restaurants.lng ) - radians(?)
                                            ) + sin( radians(?) ) *
                                            sin( radians( restaurants.lat ) ) )
                                          ) AS distance', [$lat, $lng, $lat])
                            ->orderBy('distance','ASC');
        }
        
        $query = $query->where('restaurants.verify_status', Constant::VERIFIED_STATUS)              
                ->groupBy('restaurants.id');
        if(!empty($text)){
            $query = $query->where(function($query) use ($text){
                $query->where('restaurants.name', 'LIKE', "%".$text."%");
                $query->orWhere('restaurants.address', 'LIKE', "%".$text."%");
                $query->orWhere('restaurants.description',  'LIKE', "%".$text."%");
                $query->orWhere('menus.name',  'LIKE', "%".$text."%");               
             });
        }
        
        $items = $query->paginate(30);
        
        return $items;
             
        /*return $items = DB::select(
                       'SELECT * FROM
                            (SELECT id, title, type_id, lat, lng, (' . $circle_radius . ' * acos(cos(radians(' . $lat . ')) * cos(radians(lat)) *
                            cos(radians(lng) - radians(' . $lng . ')) +
                            sin(radians(' . $lat . ')) * sin(radians(lat))))
                            AS distance
                            FROM items) AS distances
                        WHERE distance < ' . $max_distance . '
                        ORDER BY distance
                        LIMIT 20;
                    ');*/
    }
    /**
     * 
     * @param type $lat
     * @param type $lng
     * @return type
    */
    public static function getRestaurantsFavourite($text, $lat, $lng,$favIds){        
        //$circle_radius = 3959;
        //$max_distance = 100;        
        $now = date('Y-m-d',time());
        $query = Restaurant::with(['menus' => function ($query) use($now) {
                    $query->where('menus.from_date','<=',$now);
                    $query->where('menus.to_date','>=',$now);                    
                }])->select(['restaurants.*','menus.restaurant_id','menus.name as menu_name','menus.price'])
                            ->leftJoin('menus','restaurants.id', '=',  'menus.restaurant_id');
                            
        if(!empty($lat) && !empty($lng)){
            $query = $query ->selectRaw('( 6371 * acos( cos( radians(?) ) *
                                            cos( radians( restaurants.lat ) )
                                            * cos( radians( restaurants.lng ) - radians(?)
                                            ) + sin( radians(?) ) *
                                            sin( radians( restaurants.lat ) ) )
                                          ) AS distance', [$lat, $lng, $lat])
                            ->orderBy('distance','ASC');
        }
        
        $query = $query->where('restaurants.verify_status', Constant::VERIFIED_STATUS);
        
        if(!empty($text)){
            $query = $query->where(function($query) use ($text){
                $query->where('restaurants.name', 'LIKE', "%".$text."%");
                $query->orWhere('restaurants.address', 'LIKE', "%".$text."%");
                $query->orWhere('restaurants.description',  'LIKE', "%".$text."%");
                $query->orWhere('menus.name',  'LIKE', "%".$text."%");
                //$query->orWhere('item_categories.name',  'LIKE', "%".$text."%");
             });
        }
        
        if(!empty($favIds)){            
            $query = $query->whereIn('restaurants.id',$favIds);
        }
        
        $items = $query->groupBy('restaurants.id')->paginate(30);
        
        return $items;
       
    }
    /**
     * 
     * @param type $q
     * @return type
     */
    public static function getAutocompleteRestaurants($text) {
       
        $query = Restaurant::select(['restaurants.*','menus.name as menu_name'])
                            ->leftJoin('menus', 'restaurants.id', '=', 'menus.restaurant_id');      
        if(!empty($text)){
            $query = $query->where(function($query) use ($text){
                $query->where('restaurants.name', 'LIKE', "%".$text."%");
                $query->orWhere('restaurants.address',  'LIKE', "%".$text."%");
                //$query->orWhere('restaurants.description',  'LIKE', "%".$text."%");
                $query->orWhere('menus.name',  'LIKE', "%".$text."%");
             });
        }
      
        $items = $query->where('restaurants.verify_status', Constant::VERIFIED_STATUS)
                ->groupBy('restaurants.id')->get();
        
        $res_items = [];
        if($items){
            $items = $items->toArray();
            foreach ($items as $item) {
                $data = array();
                $data['id'] = $item['id'];
                $data['label'] = $item['name'];
                $data['value'] = $item['name'];

                $res_items[] = $data;
            }
        }
        return $res_items;
    }
    /**
     * 
     * @param type $lat
     * @param type $lng
     * @return type
     */
    public static function getAllDishNearbyApi($lat, $lng, $dish = '', $page=1,$per_page=50){
        
        //$circle_radius = 3959;distance by miles, 6371 by kilometers
        
        $arr_items = [];
        
        //$query = Menu::with(['foods' => function($query) {$query->select('id', 'name');}])
        $query = Menu::select(['menus.id as menu_id','menus.name as menu_name','menus.description as menu_des','menus.price','restaurants.id','restaurants.name','restaurants.currency','restaurants.lat','restaurants.lng'])
                ->leftJoin('restaurants', 'menus.restaurant_id', '=', 'restaurants.id');   
        if(!empty($lat) && !empty($lng)){
            $query = $query ->selectRaw('( 6371 * acos( cos( radians(?) ) *
                                            cos( radians( lat ) )
                                            * cos( radians( lng ) - radians(?)
                                            ) + sin( radians(?) ) *
                                            sin( radians( lat ) ) )
                                          ) AS distance', [$lat, $lng, $lat])
                            ->orderBy('distance','ASC');
        }        
        
        $now = date('Y-m-d',time());
        $query = $query->where(function($query) use($now){
                $query->where('menus.from_date','=',$now);
                $query->where('menus.to_date','=',$now);
        });
        if(!empty($dish)){  
            $dish_arr = explode(",", $dish);
            $query = $query->whereHas('foods', function ($query) use($dish_arr) {
                $query->whereIn('id',$dish_arr);
            });
        }
        
        $items = $query->where('menus.status', Constant::ACTIVE_STATUS)
                ->where('restaurants.verify_status', Constant::VERIFIED_STATUS)
                ->where('restaurants.deleted_at',NULL)
                ->paginate($per_page);
        
        if($items){
            $arr_items = $items->toArray();
            foreach ($arr_items['data'] as $key => $items) {
                $foodsObj = MenuFoodType::select(['food_types.id','food_types.name'])
                        ->leftJoin('food_types', 'menus_food_types.food_type_id', '=', 'food_types.id')
                        ->where('menus_food_types.menu_id',$items['menu_id'])
                        ->groupBy('food_types.id')
                        ->get();   
                if($foodsObj){                    
                    $arr_items['data'][$key]['foods'] = $foodsObj->toArray();
                }
                
            }            
        }
        
        return $arr_items;
    }
    /**
     * 
     * @param type $lat
     * @param type $lng
     * @return type
     */
    public static function getRestaurantsSearchApi($text, $lat, $lng,$page=1,$per_page=50){
        
        //$circle_radius = 3959;
        //$max_distance = 100;
        
        //$query = Restaurant::with('menus')->select(['restaurants.id','restaurants.name','restaurants.address','restaurants.description','menus.name as menu_name','menus.price'])
        $query = Restaurant::select(['restaurants.id','restaurants.name','restaurants.currency','restaurants.address','restaurants.description'])
                            ->leftJoin('menus','restaurants.id', '=',  'menus.restaurant_id');   
        if(!empty($lat) && !empty($lng)){
            $query = $query ->selectRaw('( 6371 * acos( cos( radians(?) ) *
                                            cos( radians( restaurants.lat ) )
                                            * cos( radians( restaurants.lng ) - radians(?)
                                            ) + sin( radians(?) ) *
                                            sin( radians( restaurants.lat ) ) )
                                          ) AS distance', [$lat, $lng, $lat])
                            ->orderBy('distance','ASC');
        }
        $query = $query->where('restaurants.verify_status', Constant::VERIFIED_STATUS)->groupBy('restaurants.id');
        if(!empty($text)){
            $query = $query->where(function($query) use ($text){
                $query->where('restaurants.name', 'LIKE', "%".$text."%");
                $query->orWhere('restaurants.address', 'LIKE', "%".$text."%");
                $query->orWhere('restaurants.description',  'LIKE', "%".$text."%");
                $query->orWhere('menus.name',  'LIKE', "%".$text."%");               
             });
        }
        
        $items = $query->paginate($per_page);
        
        return $items;
      
    }
}
