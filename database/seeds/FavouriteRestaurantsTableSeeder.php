<?php

use Illuminate\Database\Seeder;

class FavouriteRestaurantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('favourite_restaurants')->truncate();

		$favourite_restaurants = [
			[
				'restaurant_id' => '1',
				'user_id' => '2',				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
			[
				'restaurant_id' => '2',
				'user_id' => '2',				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                        [
				'restaurant_id' => '3',
				'user_id' => '2',				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                        [
				'restaurant_id' => '4',
				'user_id' => '2',				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                        [
				'restaurant_id' => '5',
				'user_id' => '2',				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                        [
				'restaurant_id' => '6',
				'user_id' => '2',				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                        [
				'restaurant_id' => '7',
				'user_id' => '2',				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                                            [
				'restaurant_id' => '8',
				'user_id' => '2',				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                                            [
				'restaurant_id' => '9',
				'user_id' => '2',				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                                            [
				'restaurant_id' => '1',
				'user_id' => '3',				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                                            [
				'restaurant_id' => '2',
				'user_id' => '3',				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                        [
				'restaurant_id' => '3',
				'user_id' => '3',				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                                            [
				'restaurant_id' => '4',
				'user_id' => '3',				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                                            [
				'restaurant_id' => '5',
				'user_id' => '3',				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                                            [
				'restaurant_id' => '6',
				'user_id' => '3',				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                                            [
				'restaurant_id' => '7',
				'user_id' => '3',				 							
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
		];

		DB::table('favourite_restaurants')->insert($favourite_restaurants);
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
