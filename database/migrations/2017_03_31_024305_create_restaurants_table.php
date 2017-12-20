<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRestaurantsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('restaurants', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191);			
			$table->string('address', 191);
                        $table->string('full_address', 191)->nullable();
                        $table->string('google_address', 191)->nullable();
			$table->string('phone', 191);
			$table->string('email', 191);
                        $table->string('currency', 3)->nullable();
                        $table->string('code_postal', 20)->nullable();
                        $table->string('ville', 191)->nullable();
                        $table->integer('siren')->nullable();
                        $table->string('ape', 20)->nullable();
                        $table->smallInteger('year')->nullable();
                        $table->mediumInteger('ca')->nullable();
                        $table->mediumInteger('resultat')->nullable();
                        $table->smallInteger('effectif')->nullable();
                        $table->string('legal_naf', 20)->nullable();
                        $table->string('legal_siret', 100)->nullable();
                        $table->smallInteger('legal_effectif_min')->nullable();
                        $table->smallInteger('legal_effectif_max')->nullable();                      
			$table->text('description')->nullable();						
			$table->double('lat', 10, 0)->nullable();
			$table->double('lng', 10, 0)->nullable();
			$table->string('slug', 191)->nullable();
                        $table->integer('view_count',false,true)->default(0);
			$table->enum('status', ['active','inactive'])->default('active');
                        $table->enum('verify_status', ['pending','verified','closed'])->default('pending');			
                        $table->softDeletes();
			$table->timestamps();
                        
                        $table->integer('type_id')->unsigned();
                        $table->foreign('type_id')->references('id')->on('item_categories');
                        $table->integer('user_id')->unsigned();
                        $table->foreign('user_id')->references('id')->on('users');
                        
                        $table->string('google_id', 191)->nullable();
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
            Schema::dropIfExists('restaurants');
            Schema::enableForeignKeyConstraints();  
	}

}
