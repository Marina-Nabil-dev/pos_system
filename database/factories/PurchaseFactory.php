<?php

namespace Database\Factories;

use App\Enums\PurchaseTypeEnum;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;

    public function configure(): static
    {
        return $this->afterCreating(function (Purchase $purchase) {

            for ($i = 0; $i < 5; $i++) {
                $purchase->products()->attach(
                    $this->faker->randomElement(Product::pluck('id')->toArray()),
                    [
                        'quantity' => $this->faker->numberBetween(1, 5),
                        'price' => $this->faker->randomFloat(2, 10, 1000),
                    ]
                );
            }

            Transaction::factory()->create([
                'purchase_id' => $purchase->id,
            ]);
        });
    }

    public function definition()
    {
        return [
            'quantity' => $this->faker->numberBetween(1, 100),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'type' => $this->faker->randomElement(PurchaseTypeEnum::values()),
            'created_at' => $this->faker->dateTimeBetween('-5 months', '2 months'),
            'updated_at' => Carbon::now(),
        ];
    }
}
