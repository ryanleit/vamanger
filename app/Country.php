<?php

namespace App;

//use App\Ultility\Constant;
//use App\Ultility\UltiFunc;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{   
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'countries';
    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'nice','code','code3','numcode','phonecode'
    ];
    
    /**
     * 
     * @return array countries
     */
    public static function getAllCountries() {
        $countries_data = [];
        $countries = Country::all();
        if($countries){
            foreach ($countries->toArray() as $country) {
                //$countries_data[$country['id']] = $country['nicename'];
                $countries_data[strtolower($country['code'])] = $country['nicename'];
            }
        }
        
        return $countries_data;
    }
}
