<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFoodTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('food_types', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191);
                        $table->text('description')->nullable(); 			
			$table->enum('status', array('active','inactive','deleted'));   		
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
            Schema::dropIfExists('food_types');
            Schema::enableForeignKeyConstraints();  
	}

}
