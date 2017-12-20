<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name',255);
            $table->string('email',200);         
            $table->string('phone',255)->nullable();                        
            $table->text('company',100)->nullable();
            $table->text('avatar')->nullable();
            $table->enum('type', array('admin','owner','user'));
            $table->enum('signup_type', array('linkedin','google','internal'));
            $table->text('social_account_info')->nullable();
            $table->dateTime('last_login')->nullable();
            $table->enum('status', array('active','pending','banned','deleted'));            
            $table->string('password');
            $table->rememberToken();
            
            $table->text('confirm_code')->nullable();            
            $table->integer('created_by')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles');           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();            
        Schema::dropIfExists('users');
        Schema::enableForeignKeyConstraints();       
    }
}
