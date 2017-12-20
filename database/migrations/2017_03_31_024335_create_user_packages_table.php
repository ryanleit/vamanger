<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUserPackagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_packages', function(Blueprint $table)
		{
			$table->integer('user_id')->unsigned();
                        $table->foreign('user_id')->references('id')->on('users');
                        $table->integer('package_id')->unsigned();
                        $table->foreign('package_id')->references('id')->on('packages');  		
                        $table->enum('status', ['active','pending','inative']);
                        $table->datetime('exprired_at');
			$table->timestamps();
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
           Schema::dropIfExists('user_packages');
           Schema::enableForeignKeyConstraints();  
	}

}
