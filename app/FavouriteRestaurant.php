<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class FavoriteRestaurant extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'favourite_restaurants';

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
    protected $fillable = ['restaurant_id', 'user_id'];
    
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
    public function restaurant()
    {
        return $this->hasOne('App\Restaurat','id');
    }
    
    /**
     * 
     * @param type $lat
     * @param type $lng
     * @return type
     */
    public static function getFavResByUser($userId){
        
        $result = [];
        
        $data = FavoriteRestaurant::select('restaurant_id')->where('user_id','=',$userId)->get();
        
        if($data){
            foreach ($data->toArray() as $value) {
                $result[] = $value['restaurant_id'];
            }
        }
        
        return $result;
    }
}
