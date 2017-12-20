<?php

use Illuminate\Database\Seeder;

class ResetDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
	DB::statement('TRUNCATE menus_food_types;');
        DB::statement('TRUNCATE menus;');
        DB::statement('TRUNCATE restaurants;');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        echo "Done!";
    }
}
