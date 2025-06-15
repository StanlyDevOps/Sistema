<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SGraficasDashboard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_graficas_dashboard', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_usuario');
            $table->unsignedInteger('id_graficas_empresas')->nullable();

            $table->foreign('id_usuario')->references('id')->on('s_usuario');
            $table->foreign('id_graficas_empresas')->references('id')->on('s_graficas_empresa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_graficas_dashboard');
    }
}
