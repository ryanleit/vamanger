<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 'create_account',
                'title' => 'Create account',
                'component_id' => 'account',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),
            1 => 
            array (
                'id' => 'create_component',
                'title' => 'Create component',
                'component_id' => 'component',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),
            2 => 
            array (
                'id' => 'create_permission',
                'title' => 'Create permission',
                'component_id' => 'permission',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),
            3 => 
            array (
                'id' => 'create_role',
                'title' => 'Create role',
                'component_id' => 'role',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),
            4 => 
            array (
                'id' => 'delete_account',
                'title' => 'Delete account',
                'component_id' => 'account',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),
            6 => 
            array (
                'id' => 'create_item',
                'title' => 'Create item',
                'component_id' => 'item',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),
            7 => 
            array (
                'id' => 'delete_component',
                'title' => 'Delete component',
                'component_id' => 'component',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),          
            8 => 
            array (
                'id' => 'delete_permission',
                'title' => 'Delete Permission',
                'component_id' => 'permission',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),
            9 => 
            array (
                'id' => 'delete_role',
                'title' => 'Delete role',
                'component_id' => 'role',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),
            10 => 
            array (
                'id' => 'delete_item',
                'title' => 'Delete item',
                'component_id' => 'item',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),   
            11 => 
            array (
                'id' => 'list_account',
                'title' => 'List account',
                'component_id' => 'account',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),
            12 => 
            array (
                'id' => 'list_advertiser',
                'title' => 'List advertiser',
                'component_id' => 'advertiser',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),
            13 => 
            array (
                'id' => 'list_component',
                'title' => 'List component',
                'component_id' => 'component',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),
            14 => 
            array (
                'id' => 'list_permission',
                'title' => 'List permission',
                'component_id' => 'permission',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),
            15 => 
            array (
                'id' => 'list_role',
                'title' => 'List role',
                'component_id' => 'role',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),
            16 => 
            array (
                'id' => 'list_item',
                'title' => 'List item',
                'component_id' => 'item',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),
            17 => 
            array (
                'id' => 'update_account',
                'title' => 'Update account',
                'component_id' => 'account',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),
            18 => 
            array (
                'id' => 'update_component',
                'title' => 'Update component',
                'component_id' => 'component',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),
            19 => 
            array (
                'id' => 'update_permission',
                'title' => 'Update permission',
                'component_id' => 'permission',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),
            20 => 
            array (
                'id' => 'update_role',
                'title' => 'Update role',
                'component_id' => 'role',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),
            21 => 
            array (
                'id' => 'update_item',
                'title' => 'Update item',
                'component_id' => 'item',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),
            22 => 
            array (
                'id' => 'view_account',
                'title' => 'View account',
                'component_id' => 'account',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),            
            23 => 
            array (
                'id' => 'view_component',
                'title' => 'View component',
                'component_id' => 'component',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),
            24 => 
            array (
                'id' => 'view_dashboard',
                'title' => 'View Dasdboard',
                'component_id' => 'dashboard',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),
            25 => 
            array (
                'id' => 'view_permission',
                'title' => 'View permission',
                'component_id' => 'permission',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),
            26 => 
            array (
                'id' => 'view_role',
                'title' => 'View role',
                'component_id' => 'role',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),
            27 => 
            array (
                'id' => 'view_item',
                'title' => 'View item',
                'component_id' => 'item',
                'deleted_at' => NULL,
                'created_at' => '2016-12-12 07:07:18',
                'updated_at' => '2016-12-12 07:07:18',
            ),    
        ));
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
