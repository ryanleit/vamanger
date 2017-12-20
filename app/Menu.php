<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
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
    protected $table = 'menus';

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
    protected $fillable = [ 'name', 'price','from_date','to_date','food_cats','restaurant_id','category_id', 'description','status'];
    
    /**
     * Get the type record associated with the item.
     */
    public function category()
    {
        return $this->belongsTo('App\Category','category_id');
    }
    /**
     * Get the type record associated with the item.
     */
    public function foods()
    {
        return $this->belongsToMany('App\FoodType','menus_food_types');
    }
}
