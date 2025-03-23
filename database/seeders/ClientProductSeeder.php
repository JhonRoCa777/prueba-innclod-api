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

        $productsId = Product::where('id', '>', 1)->pluck('id')->shuffle();

        for ($i = 1; $i <= 7; $i++) {
            ClientProduct::create([
                'client_id' => 1,
                'product_id' => $productsId[$i],
            ]);
        }
    }
}
