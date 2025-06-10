<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Inv_CategoriaTest extends TestCase
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
        # Creamos 5 ejemplos de clases
        #$categoria = factory(\App\Models\Inventario\Categoria::class,5)->create();
        self::markTestSkipped();
        $this->withSession($this->sesionJJ);

        $response = $this->post('/carpeta/pagina/true', [
            'testStids' => true,
            'carpetaControlador' => 'Inventario',
            'controlador' => 'Categoria',
            'funcionesVariables' => 'Consult',
            'buscador' => '',
            'pagina' => 1,
            'tamanhio' => 10
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
            'controlador' => 'Categoria',
            'funcionesVariables' => 'CreateOrUpdate',
            'id' => '7',
            'nombre' => 'Lacteos 1',
            'descripcion' => 'Yogurt, leche, entre otros',
            'orden' => '[{id:1}]'
        ])
            ->assertStatus(200);

        //dd($response->baseResponse->original);
    }


    public function testChangeStatus()
    {
        self::markTestSkipped();
        $this->withSession($this->sesionJJ);

        $response = $this->post('/carpeta/pagina/true', [
            'testStids' => true,
            'carpetaControlador' => 'Inventario',
            'controlador' => 'Categoria',
            'funcionesVariables' => 'ChangeStatus',
            'id' => '7'
        ])
            ->assertStatus(200);

        //dd($response->baseResponse->original);
    }


    public function testDestroy()
    {
        self::markTestSkipped();
        $this->withSession($this->sesionJJ);

        $response = $this->post('/carpeta/pagina/true', [
            'testStids' => true,
            'carpetaControlador' => 'Inventario',
            'controlador' => 'Categoria',
            'funcionesVariables' => 'Destroy',
            'id' => '7'
        ])
            ->assertStatus(200);

        //dd($response->baseResponse->original);
    }
}
