<?php

use Illuminate\Database\Seeder;

class MenusFoodTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('menus_food_types')->truncate();

		$menu_food_types = [
			[
				'menu_id' => '1',
				'food_type_id' => '1',
				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
			[
				'menu_id' => '1',
				'food_type_id' => '2',
				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                        [
				'menu_id' => '2',
				'food_type_id' => '1',
				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                        [
				'menu_id' => '2',
				'food_type_id' => '3',
				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                        [
				'menu_id' => '3',
				'food_type_id' => '1',
				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                        [
				'menu_id' => '3',
				'food_type_id' => '3',
				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                        [
				'menu_id' => '4',
				'food_type_id' => '3',
				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                                            [
				'menu_id' => '5',
				'food_type_id' => '3',
				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                                            [
				'menu_id' => '6',
				'food_type_id' => '3',
				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                                            [
				'menu_id' => '7',
				'food_type_id' => '3',
				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                                            [
				'menu_id' => '8',
				'food_type_id' => '3',
				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                                            [
				'menu_id' => '9',
				'food_type_id' => '3',
				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                                            [
				'menu_id' => '10',
				'food_type_id' => '3',
				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                                            [
				'menu_id' => '11',
				'food_type_id' => '3',
				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                                            [
				'menu_id' => '12',
				'food_type_id' => '3',
				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                                            [
				'menu_id' => '13',
				'food_type_id' => '3',
				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
		];

        DB::table('menus_food_types')->insert($menu_food_types);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
