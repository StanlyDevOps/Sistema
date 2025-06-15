<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class InvContacto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inv_contacto', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_empresa');
            $table->unsignedInteger('id_tipo_contacto');
            $table->unsignedInteger('id_tipo_identificacion')->nullable();
            $table->unsignedInteger('id_municipio')->nullable();
            $table->integer('id_usuario_vendedor')->nullable();
            $table->string('identificacion', 15)->nullable();
            $table->string('nombre', 100);
            $table->string('direccion', 80)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('telefono_1', 15)->nullable();
            $table->string('telefono_2', 15)->nullable();
            $table->string('fax', 50)->nullable();
            $table->string('celular', 15)->nullable();
            $table->text('observacion')->nullable();
            $table->enum('estado', [-1, 0, 1]);

            $table->foreign('id_empresa')->references('id')->on('s_empresa');
            $table->foreign('id_tipo_contacto')->references('id')->on('inv_tipo_contacto');
            $table->foreign('id_tipo_identificacion')->references('id')->on('s_tipo_identificacion');
            $table->foreign('id_municipio')->references('id')->on('s_municipio');

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
    }
}
