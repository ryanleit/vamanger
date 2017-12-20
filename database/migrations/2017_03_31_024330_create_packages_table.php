<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePackagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('packages', function(Blueprint $table)
		{
			$table->increments('id');
                        $table->string('name',191);
                        $table->text('description')->nullable();
			$table->float('price');			                        
			$table->enum('status', ['active','inative']);
                        $table->softDeletes();
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
           Schema::dropIfExists('packages');
           Schema::enableForeignKeyConstraints();  
	}

}
