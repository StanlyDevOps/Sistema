<?php

use Illuminate\Database\Seeder;

class s_etiqueta extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('s_etiqueta')->insert(array(

            'nombre' => 'Etiqueta de prueba',

            'clase' => 'Clase de etiqueta.',

            'diminutivo' => 'EDP',


        ));
    }
}
