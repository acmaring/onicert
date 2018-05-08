<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRespuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('respuestas', function (Blueprint $table) {
            #$table->increments('id');

            #$table->string('res_id');
            $table->increments('res_id');
            $table->string('res_content');
            $table->integer('res_correct');
            #$table->string('res_pre_id');
            $table->unsignedinteger('res_pre_id');
            #$table->primary('res_id');
            $table->foreign('res_pre_id')->references('pre_id')->on('preguntas');

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
        Schema::dropIfExists('respuestas');
    }
}
