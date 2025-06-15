<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvMateriaPrima extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_materia_prima', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_empresa');
            $table->string('referencia', 10)->nullable();
            $table->string('nombre', 50);
            $table->integer('valor');
            $table->float('iva');
            $table->integer('total');
            $table->text('descripcion');
            $table->string('imagen', 50);
            $table->enum('estado', [-1, 0, 1]);

            $table->foreign('id_empresa')->references('id')->on('s_empresa');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv_materia_prima');
    }
}
