<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Inv_ProductLocationTest extends TestCase
{
    public $sesionJJ = [
        'idEmpresa' => 1,
        'idUsuario' => 1,
        'idRol' => 1,
        'nombres' => 'Jeremy Reyes B.',
        'cambioEmpresa' => false
    ];

    public function testConsult()
    {
        self::markTestSkipped();
        $this->withSession($this->sesionJJ);

        $response = $this->post('/carpeta/pagina/true', [
            'testStids' => true,
            'carpetaControlador' => 'Inventario',
            'controlador' => 'ProductoLocacion',
            'funcionesVariables' => 'Consult',
            'buscador' => '',
            'pagina' => 1,
            'tamanhio' => 10
        ]);#->assertStatus(200);

        dd($response);
    }

    public function testInsertProductLocation()
    {
        self::markTestSkipped();
        $this->withSession($this->sesionJJ);

        $response = $this->post('/carpeta/pagina/true', [
            'testStids' => true,
            'carpetaControlador' => 'Inventario',
            'controlador' => 'ProductoLocacion',
            'funcionesVariables' => 'CreateOrUpdate',
            'id_product' => 1,
            'id_location' => 2,
            'existence' => 22,
            'stock_min' => 3,
            'stock_max' => 13,
            'id' => 1
        ]);#->assertStatus(200);

        dd($response);
    }

    public function testDelete()
    {
        self::markTestSkipped();
        $this->withSession($this->sesionJJ);

        $response = $this->post('/carpeta/pagina/true', [
            'testStids' => true,
            'carpetaControlador' => 'Inventario',
            'controlador' => 'ProductoLocacion',
            'funcionesVariables' => 'Delete',
            'id' => 1
        ]);#->assertStatus(200);

        dd($response);
    }
}
