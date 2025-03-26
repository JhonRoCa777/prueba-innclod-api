<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\ClientProduct;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_returns_client_by_document()
    {
        $client = Client::factory()->create();

        $response = $this->getJson(route('clients.getByDocument', ['client_document' => $client->document]));

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $client->id]);
    }

    /** @test */
    public function it_returns_not_found_client_by_document()
    {
        $response = $this->getJson(route('clients.getByDocument', ['client_document' => '999999']));

        $response->assertStatus(404);
    }

    /** @test */
    public function it_creates_a_client()
    {
        $data = Client::factory()->make()->toArray();

        $response = $this->postJson(route('clients.create'), $data);

        $response->assertStatus(201)
                 ->assertJsonFragment(['fullname' => $data['fullname']]);

        $this->assertDatabaseHas('clients', [
            'document' => $data['document'], 'email' => $data['email']
        ]);
    }

    /** @test */
    public function it_updates_a_client()
    {
        $client = Client::factory()->create();

        $newData = $client->toArray();
        $newData['fullname'] = 'Nuevo Nombre';

        $response = $this->putJson(route('clients.update', ['client_id' => $client->id]), $newData);

        $response->assertStatus(201)
                 ->assertJsonFragment(['fullname' => 'Nuevo Nombre']);

        $this->assertDatabaseHas('clients', [
            'id' => $client->id, 'fullname' => 'Nuevo Nombre'
        ]);
    }

    /** @test */
    public function it_returns_client_products()
    {
        $client = Client::factory()->create();
        $product = Product::factory()->create();
        ClientProduct::create(['client_id' => $client->id, 'product_id' => $product->id]);

        $response = $this->getJson(route('clients.getProducts', ['client_id' => $client->id]));

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $product->id]);
    }

    /** @test */
    public function it_returns_client_orders()
    {
        $client = Client::factory()->create();
        $order = Order::create(['client_id' => $client->id]);
        $product = Product::factory()->create();
        OrderDetail::create(['order_id' => $order->id, 'product_id' => $product->id, 'quantity' => 2]);

        $response = $this->getJson(route('clients.getOrders', ['client_id' => $client->id]));

        $response->assertStatus(200)
                 ->assertJsonFragment(['id' => $order->id]);
    }
}
