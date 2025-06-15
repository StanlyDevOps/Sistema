<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SGraficas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_graficas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_modulo')->nullable();
            $table->string('nombre', 50);
            $table->string('icono', 20);
            $table->string('descripcion', 500);
            $table->string('objeto', 30);
            $table->string('metodo', 50);
            $table->tinyInteger('estado');

            $table->foreign('id_modulo')->references('id')->on('s_modulo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_graficas');
    }
}
