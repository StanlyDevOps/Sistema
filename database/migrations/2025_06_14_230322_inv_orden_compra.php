<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvOrdenCompra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_orden_compra', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_empresa');
            $table->unsignedInteger('id_proveedor');
            $table->unsignedInteger('id_locacion');
            $table->string('codigo', 5);
            $table->integer('subtotal');
            $table->integer('total_iva');
            $table->integer('total');
            $table->text('observaciones')->nullable();
            $table->string('soporte', 30)->nullable();
            $table->date('fecha');
            $table->date('fecha_entrega');
            $table->date('fecha_creacion');
            $table->enum('estado', [-1, 0, 1]);

            $table->foreign('id_empresa')->references('id')->on('s_empresa');
            $table->foreign('id_proveedor')->references('id')->on('inv_contacto');
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
        Schema::dropIfExists('inv_orden_compra');
    }
}
