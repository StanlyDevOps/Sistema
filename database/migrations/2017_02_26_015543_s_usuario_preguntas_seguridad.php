<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SUsuarioPreguntasSeguridad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_usuario_preguntas_seguridad', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_usuario');
            $table->unsignedInteger('id_preguntas_seguridad');
            $table->unsignedInteger('id_respuesta_seguridad')->nullable();
            $table->string('respuesta', 200)->nullable();

            $table->foreign('id_usuario')->references('id')->on('s_usuario');
            $table->foreign('id_preguntas_seguridad')->references('id')->on('s_preguntas_seguridad');
            $table->foreign('id_respuesta_seguridad')->references('id')->on('s_respuesta_seguridad');
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
