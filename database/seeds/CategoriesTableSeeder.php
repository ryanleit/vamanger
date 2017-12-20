<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('categories')->truncate();

		$categories = [
			[
				'id' => '1',
				'name' => 'Starter',
				'status' => 'active',							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
			[
				'id' => '2',
				'name' => 'Main course',	
				'status' => 'active',							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                        [
				'id' => '3',
				'name' => 'Dessert',		
				'status' => 'active',							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
		];

		DB::table('categories')->insert($categories);
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
