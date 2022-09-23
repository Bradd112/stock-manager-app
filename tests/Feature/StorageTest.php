<?php

namespace Tests\Feature;

use App\Models\Storage;
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

        $storages = Storage::all();
        $this->assertEquals('Teszt raktár', $storages->first()->title);
        $this->assertEquals(10, $storages->first()->capacity);
        $this->assertEquals(1, $storages->count());

        $response = $this->post('storage', [
            'title' => 'Teszt raktár 2',
            'address' => '1111, Teszt Város, Teszt utca 3.',
            'capacity' => 5,
        ]);

        $response->assertStatus(201);

        $storages = Storage::all();
        $this->assertEquals('Teszt raktár 2', $storages->get(1)->title);
        $this->assertEquals(5, $storages->get(1)->capacity);
        $this->assertEquals(2, $storages->count());
    }

    public function test_adding_product_to_storage()
    {
        $storage = $this->createStorage();

        $response = $this->post('product', [
            'storage_id' => $storage->id,
            'title' => 'Teszt termék',
            'sku' => '1234',
            'price' => 1990,
            'tax_percentage' => 27,
        ]);

        $response->assertStatus(201);
        $response->assertJson([
            'data' => [
                'title' => 'Teszt termék',
                'sku' => '1234',
                'price' => 1990,
                'tax_percentage' => 27,
            ]
        ]);

        $storage->refresh();

        $this->assertEquals(1, $storage->products->count());
    }

    public function test_adding_too_much_product_to_storage()
    {
        $storage = $this->createStorage();

        $response = $this->post('product', [
            'storage_id' => $storage->id,
            'title' => 'Teszt termék',
            'sku' => '1234',
            'price' => 1990,
            'tax_percentage' => 27,
        ]);

        $response->assertStatus(201);

        $response = $this->post('product', [
            'storage_id' => $storage->id,
            'title' => 'Teszt termék 2',
            'sku' => '12345',
            'price' => 2190,
            'tax_percentage' => 27,
        ]);

        $response->assertStatus(201);

        $response = $this->post('product', [
            'storage_id' => $storage->id,
            'title' => 'Teszt termék 3',
            'sku' => '123456',
            'price' => 3990,
            'tax_percentage' => 27,
        ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors();
    }

    protected function createStorage(): Storage
    {
        return Storage::create([
            'title' => fake()->words(2, true),
            'address' => fake()->address(),
            'capacity' => 2,
        ]);
    }
}
