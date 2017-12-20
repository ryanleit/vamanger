<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class UserExperiencesTable extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_experiences', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->enum('like',['yes','no']);
            $table->text('comment')->nullable();						            
            $table->string('page')->nullable();
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
        Schema::dropIfExists('user_experiences');
        Schema::enableForeignKeyConstraints();  
    }
}
