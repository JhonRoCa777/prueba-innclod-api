<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_an_order()
    {
        $client = Client::factory()->create();
        $products = Product::factory()->count(2)->create(['stock' => 10]);

        $client->products()->attach($products->pluck('id'));

        $orderDetails = $products->map(function ($product) {
            return [
                'product_id' => $product->id,
                'quantity' => 2
            ];
        })->toArray();

        $payload = [
            'client_id' => $client->id,
            'order_details' => $orderDetails
        ];

        $response = $this->postJson(route('orders.create'), $payload);

        $response->assertStatus(201);
        $this->assertDatabaseHas('orders', ['client_id' => $client->id]);

        foreach ($orderDetails as $detail) {
            $this->assertDatabaseHas('order_details', [
                'order_id' => Order::first()->id,
                'product_id' => $detail['product_id'],
                'quantity' => $detail['quantity'],
            ]);

            $this->assertDatabaseHas('products', [
                'id' => $detail['product_id'],
                'stock' => 8
            ]);
        }
    }

    /** @test */
    public function it_fails_no_stock()
    {
        $client = Client::factory()->create();
        $product = Product::factory()->create(['stock' => 1]);

        $client->products()->attach($product->id);

        $payload = [
            'client_id' => $client->id,
            'order_details' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 5
                ]
            ]
        ];

        $response = $this->postJson(route('orders.create'), $payload);

        $response->assertStatus(404);

        $this->assertDatabaseMissing('orders', ['client_id' => $client->id]);
    }
}
