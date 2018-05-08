<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreguntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('preguntas', function (Blueprint $table) {
            #$table->increments('id');
            
            #$table->string('pre_id');
            $table->increments('pre_id');
            $table->string('pre_content');
            $table->integer('pre_restrict');
            $table->string('pre_com_id');
            #$table->integer('pre_com_id');
            #$table->primary('pre_id');
            $table->foreign('pre_com_id')->references('com_id')->on('competencias');

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
        Schema::dropIfExists('preguntas');
    }
}
