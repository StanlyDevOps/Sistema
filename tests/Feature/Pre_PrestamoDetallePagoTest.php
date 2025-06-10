<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Pre_PrestamoDetallePagoTest extends TestCase
{
    public $sesionJJ = [
        'idEmpresa' => 1,
        'idUsuario' => 1,
        'idRol' => 1,
        'nombres' => 'Jeremy Reyes B.',
        'cambioEmpresa' => false
    ];

    public function testRealizarPago()
    {
        self::markTestSkipped();
        $this->withSession($this->sesionJJ);

        $response = $this->post('/carpeta/pagina/true', [
            'testStids' => true,
            'curd' => true,
            'carpetaControlador' => 'Prestamo',
            'controlador' => 'PrestamoDetallePago',
            'funcionesVariables' => 'Consultar',
            'id_prestamo_detalle' => 1345
        ]);

        dd($response);
    }
}
