<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlmPedido extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alm_pedido', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_empresa');
            $table->unsignedInteger('id_mesa')->nullable();
            $table->integer('codigo');
            $table->smallInteger('anhio');
            $table->string('descripcion')->nullable();
            $table->enum('estado', [-1, 0, 1]);

            $table->foreign('id_empresa')->references('id')->on('s_empresa');
            $table->foreign('id_mesa')->references('id')->on('alm_mesa')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alm_pedido');
    }
}
