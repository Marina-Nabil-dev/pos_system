<?php

namespace Database\Factories;

use App\Enums\TransactionTypeEnum;
use App\Models\Purchase;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition()
    {
        return [
            'purchase_id' => Purchase::factory(),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'quantity' => $this->faker->numberBetween(1, 100),
            'type' => $this->faker->randomElement(TransactionTypeEnum::values()),
            'created_at' => $this->faker->dateTimeBetween('-5 months', '2 months'),
            'updated_at' => Carbon::now(),
        ];
    }
}
