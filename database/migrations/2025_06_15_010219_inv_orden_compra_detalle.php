<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvOrdenCompraDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_orden_compra_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_orden_compra');
            $table->unsignedInteger('id_producto');
            $table->string('producto', 50)->nullable();
            $table->integer('cantidad');
            $table->integer('valor');
            $table->integer('iva');
            $table->integer('total');
            $table->enum('estado', [-1, 0, 1]);

            $table->foreign('id_orden_compra')->references('id')->on('inv_orden_compra');
            $table->foreign('id_producto')->references('id')->on('inv_producto');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv_orden_compra_detalle');
    }
}
