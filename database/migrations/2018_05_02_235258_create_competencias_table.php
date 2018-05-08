<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompetenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('competencias', function (Blueprint $table) {
            #$table->increments('id');

            $table->string('com_id');
            #$table->increments('com_id');
            $table->string('com_name');
            $table->integer('com_cant');
            $table->string('com_esq_id');
            #$table->integer('com_esq_id');
            $table->primary('com_id');
            $table->foreign('com_esq_id')->references('esq_id')->on('esquemas');
            
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
        Schema::dropIfExists('competencias');
    }
}
