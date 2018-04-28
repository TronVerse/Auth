<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMhActivateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mhActivate', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('register');
            $table->string('UUID')->nullable();
            $table->boolean('useable');
            $table->integer('usetime');
            $table->dateTime('activetime');
            $table->integer('creator');
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
        //
    }
}
