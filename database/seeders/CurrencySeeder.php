<?php

namespace Database\Seeders;

use App\Domain\Models\Currency\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->create_rub();
        $this->create_usd();
    }

    private function create_rub(): void
    {
        Currency::query()->firstOrCreate([
            'id' => 'RUB'
        ], [
            'name' => 'Russian Ruble',
        ]);
    }

    private function create_usd(): void
    {
        Currency::query()->firstOrCreate([
            'id' => 'USD'
        ], [
            'name' => 'US Dollar',
        ]);
    }
}
