<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('nicename', 100)->nullable();
            $table->string('code', 2)->nullable();
            $table->string('code3', 3)->nullable();
            $table->smallInteger('numcode')->nullable();
            $table->smallInteger('phonecode')->nullable();
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
        Schema::dropIfExists('countries');
        Schema::enableForeignKeyConstraints();  
      
    }
}
