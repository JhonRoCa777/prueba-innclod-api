<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Bezhanov\Faker\Provider\Commerce;

class ProductFactory extends Factory
{
    public function definition()
    {
        $this->faker->addProvider(new Commerce($this->faker));

        return [
            'name' => $this->faker->productName(),
            'stock' => $this->faker->numberBetween(0, 10),
            'state' => true
        ];
    }
}
