<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('roles')->truncate();

		$roles = [
			[
				'id' => '1',
				'name' => 'Superadmin',
                                'description'=>'Super admin user',
                                'status'=>'active',
				'permissions' => '[]',
				'role_level' => 12,
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
			[
				'id' => '2',
				'name' => 'Admin',
                                'description'=>'admin user',
                                'status'=>'active',
				'permissions' => '["create_account","delete_account","list_account","update_account","view_account","view_dashboard","create_item","delete_item","list_item","update_item","view_item"]',
				'role_level' => 9,
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
			[
				'id' => '3',
				'name' => 'Manager',
                                'description'=>'Pro user',
                                'status'=>'active',
				'permissions' => '["list_account","create_item","delete_item","list_item","update_item","view_item"]',
				'role_level' => 6,
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
			[
				'id' => '4',
				'name' => 'Normal',
                                'description'=>'Normal user',
                                'status'=>'active',
				'permissions' => '[]',
				'role_level' => 3,				
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			]
		];

		DB::table('roles')->insert($roles);
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
