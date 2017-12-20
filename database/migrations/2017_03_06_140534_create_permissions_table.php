<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
   /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function(Blueprint $table) {
            $table->string('id');
            $table->primary('id');
            $table->string('title');
            $table->string('component_id');            
            $table->softDeletes();
            $table->timestamps();
            
            $table->foreign('component_id')->references('id')->on('components');
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
        Schema::dropIfExists('permissions');
        Schema::enableForeignKeyConstraints();  
    }
}
