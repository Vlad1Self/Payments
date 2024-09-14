<?php

namespace Database\Seeders;

use App\Domain\Models\PaymentMethod\Enum\PaymentDriverEnum;
use App\Domain\Models\PaymentMethod\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->create_testRUB_payment();
        $this->create_testUSD_payment();
        $this->create_stripe_payment();
        $this->create_paypal_payment();
    }

    private function create_testRUB_payment(): void
    {
       PaymentMethod::query()->firstOrCreate([
           'name' => 'testRUB',
       ], [
           'driver' => PaymentDriverEnum::test,
           'currency_id' => 'RUB'
       ]);
    }

    private function create_testUSD_payment(): void
    {
        PaymentMethod::query()->firstOrCreate([
            'name' => 'testUSD',
        ], [
            'driver' => PaymentDriverEnum::test,
            'currency_id' => 'USD'
        ]);
    }

    private function create_stripe_payment(): void
    {
        PaymentMethod::query()->firstOrCreate([
            'name' => 'stripe',
        ], [
            'driver' => PaymentDriverEnum::stripe,
            'currency_id' => 'USD'
        ]);
    }

    private function create_paypal_payment(): void
    {
        PaymentMethod::query()->firstOrCreate([
            'name' => 'paypal',
        ], [
            'driver' => PaymentDriverEnum::paypal,
            'currency_id' => 'USD'
        ]);
    }
}
