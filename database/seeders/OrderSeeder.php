<?php

namespace Database\Seeders;

use App\Domain\Models\Order\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Order::query()->count() == 0) {
            Order::factory()->count(100)->create();
        }
    }
}
