<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->call(CountriesTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);                
        $this->call(ComponentsTableSeeder::class);        
        $this->call(PermissionsTableSeeder::class);
        $this->call(ItemCategoriesTableSeeder::class);
        $this->call(FoodTypesTableSeeder::class);
        $this->call(RestaurantsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(MenusTableSeeder::class);  
        $this->call(MenusFoodTypesTableSeeder::class);
        //$this->call(FavouriteRestaurantsTableSeeder::class);
        $this->call(PackagesTableSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
