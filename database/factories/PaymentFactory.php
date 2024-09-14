<?php

namespace Database\Factories;

use App\Domain\Models\Currency\Currency;
use App\Domain\Models\Order\Order;
use App\Domain\Models\Payment\Enum\PaymentStatusEnum;
use App\Domain\Models\Payment\Payment;
use App\Domain\Models\Subscription\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Domain\Models\Payment\Payment>
 */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;
    public function definition(): array
    {
        $pyable = $this->getPayable();
        return [
            'status' => PaymentStatusEnum::pending,
            'currency_id' => $pyable['payable_currency'],
            'amount' => 100,
            'payable_id' => $pyable['payable_id'],
            'payable_type' => $pyable['payable_type'],
        ];
    }

    private function getPayable(): array
    {
        $payable_type = rand() % 2 ? 'subscription' : 'order';
        if ($payable_type === 'subscription') {
            $subscription = Subscription::query()->inRandomOrder()->first();
            return [
                'payable_id' => $subscription->id,
                'payable_type' => 'subscription',
                'payable_currency' => $subscription->currency_id
            ];
        } else {
            $order = Order::query()->inRandomOrder()->first();
            return [
                'payable_id' => $order->id,
                'payable_type' => 'order',
                'payable_currency' => $order->currency_id
            ];
        }

    }
}
