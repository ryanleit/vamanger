<?php

use Illuminate\Database\Seeder;

class ComponentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('components')->truncate();

		$components = [
                        [
				'id' => 'dashboard',
				'title' => 'Dashboard',
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],			
			[
				'id' => 'account',
				'title' => 'Account',
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
			/*[
				'id' => 'reporting',
				'title' => 'Reporting',
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],*/
			[
				'id' => 'role',
				'title' => 'Role',
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
			[
				'id' => 'component',
				'title' => 'Component',
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
			[
				'id' => 'permission',
				'title' => 'Permission',
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
			/*[
				'id' => 'invoice',
				'title' => 'Invoice',
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],*/
                        [
				'id' => 'item',
				'title' => 'Item',
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			]
		];

		DB::table('components')->insert($components);
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
