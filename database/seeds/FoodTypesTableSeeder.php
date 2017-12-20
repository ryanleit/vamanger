<?php

use Illuminate\Database\Seeder;

class FoodTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('food_types')->delete();

		$food_types = [
			[
				'id' => '1',
				'name' => 'Meat',
				'status' => 'active',							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
			[
				'id' => '2',
				'name' => 'Fish',	
				'status' => 'active',							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                        [
				'id' => '3',
				'name' => 'Vegetables',		
				'status' => 'active',							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
		];

		DB::table('food_types')->insert($food_types);
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
