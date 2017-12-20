<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMenusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menus', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191);			
			$table->text('description')->nullable();
			$table->float('price');	                        
                        $table->date('from_date')->default(NULL);			
                        $table->date('to_date')->default(NULL);			
			$table->enum('status', ['active','inactive']);
                        $table->softDeletes();
			$table->timestamps();                        
                        $table->integer('restaurant_id')->unsigned();
                        $table->foreign('restaurant_id')->references('id')->on('restaurants');
                        $table->integer('category_id')->unsigned();
                        $table->foreign('category_id')->references('id')->on('categories');
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
            Schema::dropIfExists('menus');
            Schema::enableForeignKeyConstraints();  
	}

}
