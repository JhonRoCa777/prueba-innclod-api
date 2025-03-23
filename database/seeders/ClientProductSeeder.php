<?php

namespace Database\Seeders;

use App\Models\ClientProduct;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ClientProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ClientProduct::create([
            'client_id' => 1,
            'product_id' => 1,
        ]);

        $productsId = Product::where('id', '!=', 1)
                     ->inRandomOrder()
                     ->limit(7)
                     ->pluck('id');

        foreach ($productsId as $productId) {
            ClientProduct::create([
                'client_id' => 1,
                'product_id' => $productId,
            ]);
        }
    }
}
