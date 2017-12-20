<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*****For API************/
Route::group(['middleware' => 'auth'], function () {
    Route::get('/api', 'HomeController@api')->name('api');
});

/*********************
 * ADMIN MANAGEMENT
 * *****************
 */
Route::group(['prefix' => 'admin','namespace' => 'Admin', 'middleware' => 'auth'], function () {
    Route::resource('components', 'ComponentController');
    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');
  //  Route::resource('users', 'UsersController');
    /* users managed route */
    Route::get('/users', 'UsersController@index')->name('users_list')->middleware("role:1|2");    
    Route::get('/users/create', 'UsersController@create')->name('user_add');    
    Route::post('/users', 'UsersController@store')->name('user_create');  
    Route::get('/users/{id}', 'UsersController@show')->name('users_show');
    Route::get('/users/{id}/edit', 'UsersController@edit')->name('user_edit');   
    Route::patch('/users/{id}/update', 'UsersController@update')->name('user_update');
    Route::delete('/users/{id}/{type}', 'UsersController@destroy')->name('user_delete');
    
    Route::group(['prefix' => 'dashboard'], function(){
        Route::get('/', 'DashboardController@index')->name('dashboard');
        Route::post('/data-chart', 'DashboardController@ajaxChartData')->name('dashboard.data-chart');
    });
    Route::get('/user-exps', 'DashboardController@userexp_list')->name('userexp_list');
    Route::get('/restaurants', 'RestaurantController@index')->name('admin_restaurant_list')->middleware("role:1|2");    
    Route::get('/restaurant/add', 'RestaurantController@create')->name('restaurant_add');    
    Route::post('/restaurant/create', 'RestaurantController@store')->name('restaurant_create');    
    Route::get('/restaurant/edit/{id}', 'RestaurantController@edit')->name('restaurant_edit');   
    Route::patch('/restaurant/update/{id}', 'RestaurantController@update')->name('restaurant_update');
    Route::delete('/restaurant/delete/{id}', 'RestaurantController@destroy')->name('restaurant_delete');
    Route::get('/ajax/get-currency/{code}', 'RestaurantController@ajaxCurrency')->name('ajax_currency');
    
    /* user admin page */
    Route::get('/profile-detail', 'UserController@profileDetail')->name('profile_detail');  
    Route::get('/profile', 'UserController@profileEdit')->name('profile_edit');   
    Route::patch('/profile', 'UserController@profileUpdate')->name('profile_update'); 
    Route::get('/password/change', 'UserController@editPassword')->name('password_edit');   
    Route::patch('/password/change', 'UserController@updatePassword')->name('password_update'); 
    //Route::get('/setting-detail/{id?}', 'UserController@settingDetail')->name('setting_detail');      
    //Route::get('/setting/{id?}', 'UserController@editSetting')->name('setting_edit');   
    //Route::patch('/setting/{id?}', 'UserController@updateSetting')->name('setting_update');   
    Route::post('/crop', 'UserController@imageUpload')->name('image_crop');   
    Route::get('/pro/dashboard', 'DashboardController@dashboard')->name('pro_dashboard');
    Route::get('/my-restaurant/list', 'RestaurantController@ownerRestaurant')->name('my_restaurant_list');   
    Route::get('/my-restaurant/add', 'RestaurantController@create')->name('my_restaurant_add');  
    Route::post('/my-restaurant/create', 'RestaurantController@store')->name('my_restaurant_create'); 
    Route::get('/my-restaurant/{id}', 'RestaurantController@myRestaurantEdit')->name('my_restaurant_edit');   
    Route::patch('/my-restaurant/{id}', 'RestaurantController@myRestaurantUpdate')->name('my_restaurant_update');   
          
    /* menu managament */
    //Menu quick
    Route::get('/menu/add/', 'MenuController@createQuick')->name('menu_add_quick');
    Route::get('/menu/add/step-2/{place_id?}', 'MenuController@createQuickStep2')->name('menu_add_quick_step2');
    Route::post('/menu/create/step-2', 'MenuController@storeQuickStep2')->name('menu_store_quick_step2');
    Route::post('/ajax/restaurants', 'MenuController@ajaxRestaurants')->name('ajax_restaurants');
    
    Route::get('/menus/{id}', 'MenuController@index')->name('menu_list');   
    Route::get('/menu/{id}', 'MenuController@edit')->name('menu_edit');   
    Route::patch('/menu/{id}', 'MenuController@update')->name('menu_update'); 
    Route::get('/menu/add/{id}', 'MenuController@create')->name('menu_add');    
    Route::post('/menu/create/{id}', 'MenuController@store')->name('menu_create');  
    Route::delete('/menu/delete/{id}', 'MenuController@destroy')->name('menu_delete');
    
    /* dish management */
    Route::get('/dishes', 'DishController@index')->name('dish_list');   
    Route::get('/dish/edit/{id}', 'DishController@edit')->name('dish_edit');   
    Route::patch('/dish/update/{id}', 'DishController@update')->name('dish_update'); 
    Route::get('/dish/add', 'DishController@create')->name('dish_add');    
    Route::post('/dish/create', 'DishController@store')->name('dish_create');  
    Route::delete('/dish/delete/{id}', 'DishController@destroy')->name('dish_delete');
});

/*Route::get('/', function () {
    
});*/
/*****
 * 
 * 
 * FRONT END
 */
Route::get('/', 'HomeController@index')->name('home_page');
Route::get('/search-home', 'HomeController@index')->name('home_search');
/* Dish add quick */
Route::get('/dish/add/', 'QuickaddController@createQuick')->name('restos_google_list');
Route::get('/dish/add/step-2/{place_id?}', 'QuickaddController@createQuickStep2')->name('dish_quick_add');
Route::post('/dish/create/step-2', 'QuickaddController@storeQuickStep2')->name('dish_quick_store');
Route::post('/ajax/restos-google', 'QuickaddController@ajaxRestaurants')->name('ajax_restos_google');
Route::get('/dish/thankyou/{resto_id}', 'QuickaddController@dishThankyou')->name('dish_thankyou');
Route::get('/like/quick', 'QuickaddController@likeQuickMenu')->name('like_quick');
Route::post('/comment/quick', 'QuickaddController@commentQuickMenu')->name('user_exp_comment');
    
Route::post('/restaurants/search', 'RestaurantController@searchRestaurants')->name('restaurant_search');
Route::get('/food-nearby', 'RestaurantController@nearbyFoods')->name('food_nearby');
Route::get('/restaurants-nearby', 'RestaurantController@nearbyRestaurants')->name('restaurant_nearby');
Route::get('/restaurants-favourite', 'RestaurantController@favouriteRestaurants')->name('restaurant_favourite');
Route::get('/restaurant/{id}/{date?}', 'RestaurantController@detailRestaurant')->name('restaurant_detail');
Route::get('/resto-valid/{code}', 'RestaurantController@verifyRestoStatus')->name("verify_restaurant");
Route::get('/menu-valid/{code}', 'RestaurantController@verifyMenuStatus')->name("verify_menu");
Route::get('/menu/delete/{id}', 'RestaurantController@deleteMenu')->name('menu_del');
/* ajax request route */
Route::get('/restaurants/auto', 'RestaurantController@autoRestaurants')->name('restaurant_auto');
Route::get('/cookie/latlng', 'RestaurantController@cookieLatlng')->name('cookie_latlng');
Route::get('/cookie/favres', 'RestaurantController@cookieFavres')->name('cookie_favres');

/* feauture, about */
Route::get('/features', 'HomeController@features')->name('features');
Route::get('/about-us', 'HomeController@aboutus')->name('about_us');
Route::get('/term-service', 'HomeController@termService')->name('termservice');
Route::get('/privacy', 'HomeController@privacy')->name('privacy');

Auth::routes();
Route::group(['prefix' => 'pro','namespace' => 'Auth'], function () {   
     // Authentication Routes...
    /*Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout');

    // Registration Routes...
    Route::get('register', 'Auth\RegisterController@showRegistrationForm');
    Route::post('register', 'Auth\RegisterController@register');

    // Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');*/
    // Registration Routes...
    Route::get('register', 'RegisterController@showProRegistrationForm')->name('pro_register_get');
    Route::post('register', 'RegisterController@proRegister')->name('pro_register_post');
});
Route::group(['prefix' => 'pro'], function () {   
    Route::get('/', 'HomeController@homePro');
    Route::get('/features', 'HomeController@proFeatures')->name('pro_features');
    Route::get('/price', 'HomeController@proPrice')->name('pro_price');
    Route::get('/contact', 'HomeController@proContact')->name('pro_contact');
    Route::get('/api', 'HomeController@proApi')->name('pro_api');
    Route::get('/reseller', 'HomeController@proReseller')->name('pro_reseller');
    Route::get('/term-service', 'HomeController@proTermservice')->name('pro_termservice');
    Route::get('/privacy', 'HomeController@proPrivacy')->name('pro_privacy');
    
});
//confirm active user
Route::get('/user/confirm/{confirm_code}', 'Auth\RegisterController@userActivation')->name("user_activation");
Route::get('/resend-email/{id}', 'Auth\RegisterController@sendMailRegister')->name("resend_email_activation");

Route::get('set-locale/{locale}', function ($locale) {
  if (in_array($locale, ['fr','en'])) {
    Session::put('locale', $locale);
  }
  return redirect()->back();
});

