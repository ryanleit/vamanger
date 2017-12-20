<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddTimezoneFields extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE `menus` CHANGE `from_date` `from_date` DATETIME NOT NULL;');
        DB::statement('ALTER TABLE `menus` CHANGE `to_date` `to_date` DATETIME NOT NULL;');
        DB::statement('ALTER TABLE `restaurants` ADD `timezone` VARCHAR(50) NULL DEFAULT NULL AFTER `slug`;');
        DB::statement('ALTER TABLE `users` ADD `timezone` VARCHAR(50) NULL DEFAULT NULL AFTER `status`;');  
    }
}
