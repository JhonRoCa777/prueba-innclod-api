<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            'name' => 'Celular Nokia',
            'stock' => 0,
            'state' => true,
        ]);

        for ($i = 1; $i < 10; $i++) {
            Product::create([
                'name' => 'Producto ' . $i,
                'stock' => rand(5, 50),
                'state' => true,
            ]);
        }
    }
}
