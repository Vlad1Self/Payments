<?php

namespace Database\Factories;

use App\Domain\Models\PaymentMethod\Enum\PaymentDriverEnum;
use App\Domain\Models\PaymentMethod\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Models\PaymentMethod\PaymentMethod>
 */
class PaymentMethodFactory extends Factory
{
    protected $model = PaymentMethod::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'driver' => PaymentDriverEnum::test,
        ];
    }
}
