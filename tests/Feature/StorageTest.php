<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StorageTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_storage()
    {
        $response = $this->post('storage', [
            'title' => 'Teszt raktár',
            'address' => '1111, Teszt Város, Teszt utca 2.',
            'capacity' => 10,
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'id' => 1,
                'title' => 'Teszt raktár',
                'address' => '1111, Teszt Város, Teszt utca 2.',
                'capacity' => 10,
            ]
        ]);
    }
}
