<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Inventario\Categoria::class, function (Faker $faker) {
    return [
        'id_empresa' => \App\Models\Parametrizacion\Empresa::where('estado',1)->first(),
        'nombre' => $faker->unique()->name,
        'descripcion' => $faker->text,
        'orden' => 1,
        'estado' => '1',
    ];
});
