<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PCodeudor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('p_codeudor', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_cliente')->nullable();
            $table->string('cedula');
            $table->date('fecha_expedicion');
            $table->string('nombres', 60);
            $table->string('apellidos', 60);
            $table->string('direccion', 100)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('celular', 20)->nullable();
            $table->enum('estado', [-1, 0, 1]);

            $table->foreign('id_cliente')->references('id')->on('p_cliente')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('p_codeudor');
    }
}
