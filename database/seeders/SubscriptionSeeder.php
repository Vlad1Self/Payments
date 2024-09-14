<?php

namespace Database\Seeders;

use App\Domain\Models\Subscription\Subscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubscriptionSeeder extends Seeder
{

    public function run(): void
    {
        if (Subscription::query()->count() == 0) {
            Subscription::factory()->count(100)->create();
        }
    }
}
