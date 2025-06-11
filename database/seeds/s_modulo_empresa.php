<?php

use Illuminate\Database\Seeder;

class s_modulo_empresa extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('s_modulo_empresa')->insert(array(

            'id_modulo' => 1,

            'id_empresa' => 1

        ));
    }
}
