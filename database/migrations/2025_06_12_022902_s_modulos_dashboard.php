<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SModulosDashboard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_modulos_dashboard', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_usuario');
            $table->unsignedInteger('id_modulo_empresa');
            $table->integer('orden');

            $table->foreign('id_usuario')->references('id')->on('s_usuario');
            $table->foreign('id_modulo_empresa')->references('id')->on('s_modulo_empresa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_modulos_dashboard');
    }
}
