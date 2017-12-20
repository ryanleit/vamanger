<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class ItemCategory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'item_categories';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';
    
    /**
     * 
     * @return type
     */
    public static function getItemCategories(){
        
        $categories = DB::table('item_categories')->where('status', 'active')->get()->toArray();
        
        $res_cat = [];
        foreach ($categories as $cat) {
            $res_cat[$cat->id] = $cat->name;
        }
        return $res_cat;
    }
}
