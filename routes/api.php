<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
 
Route::group(['prefix' => 'v1','namespace' => 'Api', 'middleware' => 'auth:api'], function () {    
    Route::get('/food-nearby', 'RestaurantApiController@nearbyFoods')->name('api_food_nearby');
    Route::get('/restaurants-nearby', 'RestaurantApiController@nearbyRestaurants')->name('api_restaurant_nearby');
    Route::get('/restaurants-favourite', 'RestaurantApiController@favouriteRestaurants')->name('api_restaurant_favourite');
    Route::get('/restaurant/{id}/{date?}', 'RestaurantApiController@detailRestaurant')->name('api_restaurant_detail');
    
    Route::post('/restaurant/add', 'RestaurantApiController@addResto')->name('api_restaurant_add');
    Route::get('/restos-google', 'MenuApiController@getRestaurantsGoogle')->name('api_restaurant_google_api');
    Route::post('/restos-google', 'MenuApiController@restaurantsGoogle')->name('api_restaurant_google');
    Route::get('/restos-detail-google/{place_id}', 'MenuApiController@getDetailRestoGoogle')->name('api_restaurant_google');
    Route::post('/menu-create-google', 'MenuApiController@storeMenuGoogle')->name('api_menu_create_google');
    
    Route::get('/categories', 'FoodTypeApiController@foodList')->name('api_dishes_list');
    
    Route::get('/about', 'HomeApiController@about')->name('api_about');
});