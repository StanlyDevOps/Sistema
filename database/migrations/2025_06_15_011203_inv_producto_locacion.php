<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvProductoLocacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_producto_locacion', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_producto');
            $table->unsignedInteger('id_locacion');
            $table->integer('existencia');
            $table->integer('stock_min');
            $table->integer('stock_max');
            $table->enum('estado', [-1, 0, 1]);

            $table->foreign('id_producto')->references('id')->on('inv_producto');
            $table->foreign('id_locacion')->references('id')->on('inv_locacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv_producto_locacion');
    }
}
