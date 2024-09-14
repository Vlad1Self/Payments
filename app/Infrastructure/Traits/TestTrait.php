<?php

namespace App\Infrastructure\Traits;

use App\Domain\Models\Currency\Currency;
use App\Domain\Models\Order\Order;
use App\Domain\Models\Payment\Enum\PaymentPayableEnum;
use App\Domain\Models\Payment\Enum\PaymentStatusEnum;
use App\Domain\Models\Payment\Payment;
use App\Domain\Models\PaymentMethod\Enum\PaymentDriverEnum;
use App\Domain\Models\PaymentMethod\PaymentMethod;
use App\Domain\Models\Subscription\Subscription;
use App\Domain\Models\User\User;

trait TestTrait
{
    public function create_data(): void
    {
        $this->create_users();
        $this->create_currencies();
        $this->create_orders();
        $this->create_subscriptions();
        $this->create_payment_methods();
        $this->create_payments();
    }

    public function create_orders(): void
    {
        $order_one = new Order;

        $order_one->user_id = 1;
        $order_one->currency_id = "RUB";
        $order_one->price = 100;
        $order_one->save();

        $order_two = new Order;

        $order_two->user_id = 1;
        $order_two->currency_id = "RUB";
        $order_two->price = 200;
        $order_two->save();
    }

    public function create_subscriptions(): void
    {
        $subscription_one = new Subscription;

        $subscription_one->user_id = 1;
        $subscription_one->price = 100;
        $subscription_one->currency_id = "RUB";
        $subscription_one->save();

        $subscription_two = new Subscription;

        $subscription_two->user_id = 1;
        $subscription_two->price = 200;
        $subscription_two->currency_id = "RUB";
        $subscription_two->save();
    }

    public function create_users(): void
    {
        $user_one = new User;

        $user_one->name = "test";
        $user_one->email = "test@mail.ru";
        $user_one->password = "test";
        $user_one->save();

        $user_two = new User;

        $user_two->name = "test";
        $user_two->email = "test2@mail.ru";
        $user_two->password = "test";
        $user_two->save();
    }

    public function create_currencies(): void
    {
        $rub = new Currency;

        $rub->name = "RUB";
        $rub->id = "RUB";
        $rub->save();
    }

    public function create_payment_methods(): void
    {
        $payment_method_one = new PaymentMethod;

        $payment_method_one->name = "test";
        $payment_method_one->driver = PaymentDriverEnum::test;
        $payment_method_one->active = true;
        $payment_method_one->currency_id = "RUB";
        $payment_method_one->save();
    }

    public function create_payments(): void
    {
        $payment_one = new Payment;

        $payment_one->currency_id = Currency::query()->inRandomOrder()->first()->id;
        $payment_one->payable_id = 3;
        $payment_one->payable_type = PaymentPayableEnum::order;
        $payment_one->status = PaymentStatusEnum::pending;
        $payment_one->payment_method_id = PaymentMethod::query()->inRandomOrder()->first()->id;
        $payment_one->amount = 100;
        $payment_one->save();
    }

    public function get_order(): Order
    {
        return Order::query()->inRandomOrder()->first();
    }

    public function get_subscription(): Subscription
    {
        return Subscription::query()->inRandomOrder()->first();
    }
}
