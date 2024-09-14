<?php

namespace Database\Factories;

use App\Domain\Models\Currency\Currency;
use App\Domain\Models\Payable\Enum\PayableStatusEnum;
use App\Domain\Models\Subscription\Subscription;
use App\Domain\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Models\Subscription\Subscription>
 */
class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;
    public function definition(): array
    {
        return [
            'price' => 100,
            'currency_id' => Currency::query()->inRandomOrder()->first()->id,
            'user_id' => User::query()->inRandomOrder()->first()->id,
            'status' => PayableStatusEnum::new,
        ];
    }
}
