<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Inv_CategoriaOrdenTest extends TestCase
{
    public $sesionJJ = [
        'idEmpresa' => 1,
        'idUsuario' => 1,
        'idRol' => 1,
        'nombres' => 'Jeremy Reyes B.',
        'cambioEmpresa' => false
    ];

    public function testConsultar()
    {
        self::markTestSkipped();
        $this->withSession($this->sesionJJ);

        $response = $this->post('/carpeta/pagina/true', [
            'testStids' => true,
            'carpetaControlador' => 'Inventario',
            'controlador' => 'CategoriaOrden',
            'funcionesVariables' => 'Consult'
        ])->assertStatus(200);

        //dd($response);
    }

    public function testCreateOrUpdate()
    {
        self::markTestSkipped();
        $this->withSession($this->sesionJJ);

        $response = $this->post('/carpeta/pagina/true', [
            'testStids' => true,
            'carpetaControlador' => 'Inventario',
            'controlador' => 'CategoriaOrden',
            'funcionesVariables' => 'CreateOrUpdate',
            'orden' => '[{"id":1},{"id":2},{"id":3,"children":[{"id":4},{"id":5},{"id":6,"children":[{"id":7},{"id":8}]}]}]---',
            'id' => ''
        ])->assertStatus(200);

        //dd($response);
    }
}
