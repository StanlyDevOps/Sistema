<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvProducto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_producto', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_empresa');
            $table->unsignedInteger('id_categoria');
            $table->unsignedInteger('id_impuesto');
            $table->unsignedInteger('id_unidades');
            $table->string('nombre', 100);
            $table->string('referencia', 20);
            $table->decimal('valor', 15);
            $table->text('descripcion')->nullable();
            $table->string('imagen', 50)->nullable();
            $table->enum('estado', [-1, 0, 1])->nullable();

            $table->foreign('id_empresa')->references('id')->on('s_empresa');
            $table->foreign('id_categoria')->references('id')->on('inv_categoria');
            $table->foreign('id_impuesto')->references('id')->on('inv_impuesto');
            $table->foreign('id_unidades')->references('id')->on('inv_unidades');
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
        Schema::dropIfExists('inv_orden_compra_detalle');
        Schema::dropIfExists('alm_pedido_detalle');
        Schema::dropIfExists('inv_producto_locacion');
        Schema::dropIfExists('inv_producto');
    }
}
