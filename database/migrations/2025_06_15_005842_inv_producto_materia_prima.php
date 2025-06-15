<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvProductoMateriaPrima extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_producto_materia_prima', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_producto');
            $table->unsignedInteger('id_materia_prima');

            $table->foreign('id_producto')->references('id')->on('inv_producto');
            $table->foreign('id_materia_prima')->references('id')->on('inv_materia_prima');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv_producto_materia_prima');
    }
}
