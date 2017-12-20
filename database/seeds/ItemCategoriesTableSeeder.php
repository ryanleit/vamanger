<?php

use Illuminate\Database\Seeder;

class ItemCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('item_categories')->truncate();

		$categories = [
			[
				'id' => '1',
				'name' => 'Plats',
                                'description' => 'Plats category',
				'status' => 'active',							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
			[
				'id' => '2',
				'name' => 'Restos',	
                                'description' => 'Restos category',
				'status' => 'active',							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                        [
				'id' => '3',
				'name' => 'Promos',		
                                'description' => 'Promos category',
				'status' => 'active',							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
		];

		DB::table('item_categories')->insert($categories);
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
