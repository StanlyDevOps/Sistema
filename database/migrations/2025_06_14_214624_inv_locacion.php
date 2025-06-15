<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvLocacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_locacion', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_bodega');
            $table->string('nombre', 45);
            $table->text('descripcion')->nullable();
            $table->integer('existencia');
            $table->integer('stock_min');
            $table->integer('stock_max');
            $table->enum('estado', [-1, 0, 1]);

            $table->foreign('id_bodega')->references('id')->on('inv_bodega');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv_locacion');
    }
}
