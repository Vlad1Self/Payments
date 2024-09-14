<?php

namespace Database\Factories;

use App\Domain\Models\Currency\Currency;
use App\Domain\Models\Order\Order;
use App\Domain\Models\Payable\Enum\PayableStatusEnum;
use App\Domain\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;
    public function definition(): array
    {
        return [
            'status' => PayableStatusEnum::new,
            'price' => $this->faker->randomFloat(2, 0, 1000),
            'user_id' => User::query()->inRandomOrder()->first()->id,
            'currency_id' => Currency::query()->inRandomOrder()->first()->id
        ];

    }
}
