<?php

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('menus')->delete();
        
        DB::table('menus')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Pizza food',    
                'description' => "Our bestseller! Freshly deep fried chicken wings dipped in Chicken Up\'s special soya sauce blend",
                'price' => '43.454',
                'from_date' => '2017-06-16 00:00:00',
                'to_date' => '2017-06-16 00:00:00',
                'restaurant_id'=>1,
                'category_id' =>1,
                'status' => 'active',
                'created_at' => '2017-03-06 14:00:30',
                'updated_at' => '2017-03-06 14:00:30',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Bun Bo', 
                'description' => "Crispy chicken wings with Korean spicy sweet chilli sauce",
                'price' => '432.454',
                'from_date' => '2017-03-06 14:00:30',
                'to_date' => '2017-06-16 00:00:00',
                'restaurant_id'=>1,
                'category_id' =>1,
                'status' => 'active',
                'created_at' => '2017-03-06 14:00:30',
                'updated_at' => '2017-03-06 14:00:30',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Pho dac biet',                
                'description' => "French fries with a nice touch of aromatic truffle oil, sprinkled with parsley flakes and salts",
                'price' => '443.454',
                'from_date' => '2017-03-06 14:00:30',
                'to_date' => '2017-06-16 00:00:00',
                'restaurant_id'=>1,
                'category_id' =>1,
                'status' => 'active',
                'created_at' => '2017-03-06 14:00:30',
                'updated_at' => '2017-03-06 14:00:30',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Goi bo',                
                'description' => "prawns, squid, chili pepper, onion and chives prepared with Korean batter mix and beef seasoning",
                'price' => '243.454',
                'from_date' => '2017-03-06 14:00:30',
                'to_date' => '2017-06-16 00:00:00',
                'restaurant_id'=>1,
                'category_id' =>2,
                'status' => 'active',
                'created_at' => '2017-03-06 14:00:30',
                'updated_at' => '2017-03-06 14:00:30',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Suon cay',      
                'description' => "Crispy chicken wings with Korean sweet chili sauce",
                'price' => '13.454',
                'from_date' => '2017-03-06 14:00:30',
                'to_date' => '2017-06-16 00:00:00',
                'restaurant_id'=>1,
                'category_id' =>2,
                'status' => 'active',
                'created_at' => '2017-03-06 14:00:30',
                'updated_at' => '2017-03-06 14:00:30',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Mi Quang',                
                'description' => "Enjoy the original crunch on your first bite!",
                'price' => '453.454',
                'from_date' => '2017-04-17 14:00:30',
                'to_date' => '2018-10-06 14:00:30',
                'restaurant_id'=>2,
                'category_id' =>2,
                'status' => 'active',
                'created_at' => '2017-03-06 14:00:30',
                'updated_at' => '2017-03-06 14:00:30',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Bun bo',                
                'description' => "Fully loaded with thin slices of beef marinated in secret sauce on top of freshly deep fried potato chips",
                'price' => '453.454',
                'from_date' => '2017-04-18 14:00:30',
                'to_date' => '2017-06-16 00:00:00',
                'restaurant_id'=>2,
                'category_id' =>2,
                'status' => 'active',
                'created_at' => '2017-03-06 14:00:30',
                'updated_at' => '2017-03-06 14:00:30',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'Com hen',                
                'description' => "Rice cake, vegitables and fish cakes, mussels, squid, scallops and prawns cooked in Korean chili sauce with beef seasoning",
                'price' => '6643.454',
                'from_date' => '2017-03-06 14:00:30',
                'to_date' => '2017-06-16 00:00:00',
                'restaurant_id'=>2,
                'category_id' =>2,
                'status' => 'active',
                'created_at' => '2017-03-06 14:00:30',
                'updated_at' => '2017-04-16 14:00:30',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Che dau xanh',   
                'description' => "Enjoy the original crunch on your first bite!",
                'price' => '99.454',
                'from_date' => '2017-03-06 14:00:30',
                'to_date' => '2017-06-16 00:00:00',
                'restaurant_id'=>2,
                'category_id' =>3,
                'status' => 'active',
                'created_at' => '2017-03-06 14:00:30',
                'updated_at' => '2017-03-06 14:00:30',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Nuoc dua',                
                'description' => "Enjoy the original crunch on your first bite!",
                'price' => '4443.454',
                'from_date' => '2017-03-06 14:00:30',
                'to_date' => '2017-06-16 00:00:00',
                'restaurant_id'=>2,
                'category_id' =>3,
                'status' => 'active',
                'created_at' => '2017-03-06 14:00:30',
                'updated_at' => '2017-03-06 14:00:30',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Nuoc mia',                
                'description' => "Enjoy the original crunch on your first bite!",
                'price' => '13.454',
                'from_date' => '2017-03-06 14:00:30',
                'to_date' => '2017-06-16 00:00:00',
                'restaurant_id'=>3,
                'category_id' =>3,
                'status' => 'active',               
                'created_at' => '2017-03-06 14:00:30',
                'updated_at' => '2017-03-06 14:00:30',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Pizza food',                
                'description' => "Enjoy the original crunch on your first bite!",
                'price' => '43.454',
                'from_date' => '2017-03-06 14:00:30',
                'to_date' => '2017-06-16 00:00:00',
                'restaurant_id'=>3,
                'category_id' =>1,
                'status' => 'active',
                'created_at' => '2017-03-06 14:00:30',
                'updated_at' => '2017-03-06 14:00:30',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'Tom nuong',                
                'description' => "Enjoy the original crunch on your first bite!",
                'price' => '443.454',
                'from_date' => '2017-03-06 14:00:30',
                'to_date' => '2017-06-16 00:00:00',
                'restaurant_id'=>3,
                'category_id' =>3,
                'status' => 'active',
                'created_at' => '2017-03-06 14:00:30',
                'updated_at' => '2017-03-06 14:00:30',
            ),
        ));
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
    }
}