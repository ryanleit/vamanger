<?php

namespace App\Providers;

//use Laravel\Passport\Passport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
         
        Validator::extend('unique_menu_name', function ($attribute, $value, $parameters, $validator) {
             // Get the parameters passed to the rule
            list($fromDate, $restaurantId, $menuId) = $parameters;

            if(empty($menuId)){
                return DB::table('menus')->where('name',$value)->where('from_date', $fromDate)->where('restaurant_id', $restaurantId)->whereNull('deleted_at')->count() == 0;
            }else{
                return DB::table('menus')->where('name',$value)->where('from_date', $fromDate)->where('restaurant_id', $restaurantId)->where('id','!=', $menuId)->whereNull('deleted_at')->count() == 0;
            }            
        });
        
         Validator::extend('unique_restaurant', function ($attribute, $value, $parameters, $validator) {
             // Get the parameters passed to the rule
            list($phone, $restaurantId) = $parameters;

            if(empty($restaurantId)){
                return DB::table('restaurants')->where('name',$value)->where('phone', $phone)->whereNull('deleted_at')->count() == 0;
            }else{
                return DB::table('restaurants')->where('name',$value)->where('phone', $phone)->where('id','!=', $restaurantId)->whereNull('deleted_at')->count() == 0;
            }            
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {      
        //
        $this->app->alias('bugsnag.logger', \Illuminate\Contracts\Logging\Log::class);
        $this->app->alias('bugsnag.logger', \Psr\Log\LoggerInterface::class);
        
        //Passport::ignoreMigrations();     
    }
}
