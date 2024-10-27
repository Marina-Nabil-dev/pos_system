<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'stock_quantity' => $this->faker->numberBetween(1, 100),
            'created_at' => $this->faker->dateTimeBetween('-5 months', '2 months'),
            'updated_at' => Carbon::now(),
        ];
    }
}
