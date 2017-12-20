<?php

use Illuminate\Database\Seeder;

class PackagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('packages')->delete();
        
        DB::table('packages')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Free',    
                'description' => "Free package name",
                'price' => '43.454',                                
                'status' => 'active',
                'created_at' => '2017-03-06 14:00:30',
                'updated_at' => '2017-03-06 14:00:30',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Preminum', 
                'description' => "Premium package name",
                'price' => '432.454',
                'status' => 'active',
                'created_at' => '2017-03-06 14:00:30',
                'updated_at' => '2017-03-06 14:00:30',
            )
        ));
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
    }
}