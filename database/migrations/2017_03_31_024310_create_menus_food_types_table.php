<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenusFoodTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menus_food_types', function(Blueprint $table)
		{
			$table->integer('menu_id')->unsigned();
                        $table->foreign('menu_id')->references('id')->on('menus');
                        $table->integer('food_type_id')->unsigned();
                        $table->foreign('food_type_id')->references('id')->on('food_types');  		
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
            Schema::dropIfExists('menus_food_types');
            Schema::enableForeignKeyConstraints();  
	}

}
