<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);

        $this->call(CurrencySeeder::class);

        $this->call(OrderSeeder::class);

        $this->call(SubscriptionSeeder::class);

        $this->call(PaymentMethodSeeder::class);

        $this->call(PaymentSeeder::class);

    }
}
