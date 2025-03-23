<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderAndDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clientId = 1;

        for ($orderIndex = 1; $orderIndex <= 2; $orderIndex++) {

            $productsId = Product::where('id', '>', 1)->pluck('id')->shuffle();

            $order = Order::create([
                'client_id' => $clientId,
            ]);

            $selectedProducts = $productsId->random(3);

            foreach ($selectedProducts as $productId) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => rand(1, 5),
                ]);
            }
        }
    }
}
