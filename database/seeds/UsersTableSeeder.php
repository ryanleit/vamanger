<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
		DB::table('users')->truncate();

		$users = [
			[
				'id' => '1',
				'name' => 'Superadmin',				
				'email' => 'super.admin@gmail.com',
				'type' => 'admin',
				'signup_type' => 'internal',
				'password' => bcrypt(123456),
				'status' => 'active',
				'role_id' => 1,	                                
				'created_by' => null,				
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
			[
				'id' => '2',
				'name' => 'Admin',				
				'email' => 'admin@admin.com',
				'type' => 'admin',
				'signup_type' => 'internal',
				'password' => bcrypt('sylvain123'),
				'status' => 'active',
				'role_id' => 2,				                               
				'created_by' => 1,				
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                        [
				'id' => '3',
				'name' => 'User Pro',				
				'email' => 'pro@pro.com',
				'type' => 'owner',
				'signup_type' => 'internal',
				'password' => bcrypt('sylvain123'),
				'status' => 'active',
				'role_id' => 3,				                               				
				'created_by' => 1,				
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                        [
				'id' => '4',
				'name' => 'api',				
				'email' => 'api@api.com',
				'type' => 'user',
				'signup_type' => 'internal',
				'password' => bcrypt('Aa123456'),
				'status' => 'active',
				'role_id' => 4,				                               				
				'created_by' => 1,				
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			],
                        [
				'id' => '5',
				'name' => 'User Normal',				
				'email' => 'normal_user@mail.com',
				'type' => 'user',
				'signup_type' => 'internal',
				'password' => bcrypt(123456),
				'status' => 'active',
				'role_id' => 4,				                              			
				'created_by' => 1,				
				'created_at' => new DateTime,
				'updated_at' => new DateTime
			]
		];

		DB::table('users')->insert($users);
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
