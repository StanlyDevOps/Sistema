<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateSModuloEmpresaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_modulo_empresa', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_modulo');
            $table->unsignedInteger('id_empresa');
            $table->timestamps();
            $table->foreign('id_modulo')->references('id')->on('s_modulo');
            $table->foreign('id_empresa')->references('id')->on('s_empresa');
            $table->unique(['id_modulo', 'id_empresa']);
        });

        $clase = new s_modulo_empresa();

        $clase->run();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('s_modulo_empresa');
    }
}
