<?php

use Illuminate\Database\Seeder;

class RestaurantsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \DB::table('restaurants')->delete();
        
        \DB::table('restaurants')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Restaurant XYZ',                
                'address' => 'test address',
                'phone' => '123912391279',
                'email' => 'abc@email.com',
                'description' => 'abc Description',
                'type_id' => 2, 
                'user_id' => 2,                  
                'lat' => 44.8235,
                'lng' => 8.3583,                 
                'slug' => 'item-slug',
                'status' => 'active',
                'verify_status'=>'verified',
                'created_at' => '2017-03-06 14:00:30',
                'updated_at' => '2017-03-06 14:00:30',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'BBQ RES',                 
                'address' => 'test address',
                'phone' => '123912391279',
                'email' => 'abc@email.com',
                'description' => 'abc Description',
                'type_id' => 2, 
                'user_id' => 3,                  
                'lat' => 44.9927,
                'lng' => 8.1366,                 
                'slug' => 'item-slug',
                'status' => 'active',
                'verify_status'=>'verified',
                'created_at' => '2017-03-06 14:00:30',
                'updated_at' => '2017-03-06 14:00:30',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Test restaurant food',                 
                'address' => 'test address',
                'phone' => '123912391279',
                'email' => 'abc@email.com',
                'description' => 'abc Description',
                'type_id' => 2, 
                'user_id' => 2,                  
                'lat' => 44.785,
                'lng' => 8.182,                 
                'slug' => 'item-slug',
                'status' => 'active',
                'verify_status'=>'verified',
                'created_at' => '2017-03-06 14:00:30',
                'updated_at' => '2017-03-06 14:00:30',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Salt Kitchen & Bar',                 
                'address' => 'test address',
                'phone' => '123912391279',
                'email' => 'abc@email.com',
                'description' => 'abc Description',
                'type_id' => 2, 
                'user_id' => 2,                  
                'lat' => 44.8783,
                'lng' => 7.9942,                 
                'slug' => 'item-slug',
                'status' => 'active',
                'verify_status'=>'verified',
                'created_at' => '2017-03-06 14:00:30',
                'updated_at' => '2017-03-06 14:00:30',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'The Wellington Room',                 
                'address' => 'test address',
                'phone' => '123912391279',
                'email' => 'abc@email.com',
                'description' => 'abc Description',
                'type_id' => 2, 
                'user_id' => 2,
                'lat' => 44.9994,
                'lng' => 8.3006,
                'slug' => 'item-slug',
                'status' => 'active',
                'verify_status'=>'verified',
                'created_at' => '2017-03-06 14:00:30',
                'updated_at' => '2017-03-06 14:00:30',
            ),            
        ));
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}