<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlmPedidoDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alm_pedido_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_pedido');
            $table->unsignedInteger('id_producto_locacion');
            $table->unsignedInteger('id_producto')->nullable();
            $table->integer('id_paquete')->nullable();
            $table->string('producto', 100);
            $table->string('unidad', 5)->nullable();
            $table->decimal('valor', 15);
            $table->decimal('impuesto', 15);
            $table->decimal('total_general', 15);
            $table->enum('estado', [-1, 0, 1]);

            $table->foreign('id_pedido')->references('id')->on('alm_pedido');
            $table->foreign('id_producto_locacion')->references('id')->on('inv_producto_locacion');
            $table->foreign('id_producto')->references('id')->on('inv_producto');
            //$table->foreign('id_paquete')->references('id')->on('inv_paquete');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alm_pedido_detalle');
    }
}
