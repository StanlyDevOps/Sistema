<?php

namespace Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Inv_ProductTest extends TestCase
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
            'controlador' => 'Producto',
            'funcionesVariables' => 'Consult',
            'buscador' => '',
            'pagina' => 1,
            'tamanhio' => 10
        ]);#->assertStatus(200);

        dd($response);
    }

    public function testAvancedConsultation()
    {
        self::markTestSkipped();
        $this->withSession($this->sesionJJ);

        $response = $this->post('/carpeta/pagina/true', [
            'testStids' => true,
            'carpetaControlador' => 'Inventario',
            'controlador' => 'Producto',
            'funcionesVariables' => 'AvancedConsultation',
            'buscador' => '',
            'pagina' => 1,
            'tamanhio' => 10,
            'id_category' => null,
            'id_tax' => null,
            'id_unity' => 2
        ]);#->assertStatus(200);

        dd($response);
    }

    public function testDetail()
    {
        self::markTestSkipped();
        $this->withSession($this->sesionJJ);

        $response = $this->post('/carpeta/pagina/true', [
            'testStids' => true,
            'carpetaControlador' => 'Inventario',
            'controlador' => 'Producto',
            'funcionesVariables' => 'FindByID',
            'id' => 1
        ]);#->assertStatus(200);

        dd($response);
    }

    public function testChangeStatus()
    {
        self::markTestSkipped();
        $this->withSession($this->sesionJJ);

        $response = $this->post('/carpeta/pagina/true', [
            'testStids' => true,
            'carpetaControlador' => 'Inventario',
            'controlador' => 'Producto',
            'funcionesVariables' => 'ChangeStatus',
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
            'controlador' => 'Producto',
            'funcionesVariables' => 'Delete',
            'id' => 1
        ]);#->assertStatus(200);

        dd($response);
    }

    public function testUpdateImage()
    {
        self::markTestSkipped();
        $this->withSession($this->sesionJJ);

        $response = $this->post('/carpeta/pagina/true', [
            'testStids' => true,
            'carpetaControlador' => 'Inventario',
            'controlador' => 'Producto',
            'funcionesVariables' => 'UpdateImage',
            'id' => 1,
            'file_name' => 'imagen',
            'imagen' => UploadedFile::fake()->image('avatar.jpg', 100, 100)
        ]);#->assertStatus(200);

        dd($response);
    }

    public function testCreateOrUpdate()
    {
        self::markTestSkipped();
        $this->withSession($this->sesionJJ);

        $response = $this->post('/carpeta/pagina/true', [
            'testStids' => true,
            'carpetaControlador' => 'Inventario',
            'controlador' => 'Producto',
            'funcionesVariables' => 'CreateOrUpdate',
            'id' => 2,
            'id_category' => 68,
            'id_location' => 1,
            'id_tax' => 1,
            'id_unity' => 4,
            'name' => 'LG G6',
            'reference' => 'MOV-LG-302937',
            'value' => 1999980.03,
            'description' => 'El LG G6 tiene un diseño refinado resistente al agua y una pantalla casi sin bordes que lo hacen relativamente compacto a pesar de ser de 5.7 pulgadas. La combinación de cámaras es un placer de usar y es algo difícil de encontrar en el mercado; tiene ranura microSD y su desempeño muy bueno.',
        ]);#->assertStatus(200);

        dd($response);
    }
}
