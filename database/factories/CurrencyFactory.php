<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Models\Currency\Currency>
 */
class CurrencyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'id' => $this->faker->currencyCode(),
            'name' => $this->faker->currencyCode(),
        ];
    }
}
