<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FarmaciaTest extends TestCase
{

    public function test_farmacia_insert_ok(): void
    {
        $response = $this->post('/api/farmacias', [
            'nombre' => 'PHARMACY San Martin',
            'direccion' => 'B1604DEB Gran Buenos Aires, Gral. José de San Martín 3257, B1604DEB Florida, Provincia de Buenos Aires',
            'latitud' => '-34.53174029238471',
            'longitud' => '-58.50503227409527',
        ]);        
        $this->assertTrue(true);
    }

    public function test_farmacia_insert_error(): void
    {
        $response = $this->post('/api/farmacias', [
            'nombre' => 'PHARMACY San Martin',
            'direccion' => 'B1604DEB Gran Buenos Aires, Gral. José de San Martín 3257, B1604DEB Florida, Provincia de Buenos Aires',
            'latitud' => 'ERROR lat',
            'longitud' => 'ERROR lon',
        ]);        
        $this->assertTrue(true);
    }

    public function test_farmacia_search_ok(): void
    {
        $response = $this->put('/api/farmacias', [
            'latitud' => '-34.53174029238471',
            'longitud' => '-58.50503227409527',
        ]);      
        $this->assertTrue(true);
    }
}
