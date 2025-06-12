<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SRespuestaSeguridad extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_respuesta_seguridad', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_pregunta_seguridad');
            $table->string('descripcion', 100);
            $table->tinyInteger('estado')->default(1);

            $table->foreign('id_pregunta_seguridad')->references('id')->on('s_preguntas_seguridad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_respuesta_seguridad');
    }
}
