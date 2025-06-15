<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvTipoContacto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_tipo_contacto', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 50);
            $table->enum('estado', [-1, 0, 1]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inv_contacto');
        Schema::dropIfExists('inv_tipo_contacto');
    }
}
