<?php

namespace App\Infrastructure\Repository\PaymentMethod;

use App\Application\Services\PaymentMethod\Driver\PaymentDriver;
use App\Domain\Models\Payment\Payment;
use App\Domain\Models\PaymentMethod\PaymentMethod;
use App\Infrastructure\Repository\PaymentMethod\Factory\PaymentDriverFactory;
use Illuminate\Database\Eloquent\Collection;

class PaymentMethodCrudRepository implements PaymentMethodCrudContract
{

    public function index(): Collection
    {
        return PaymentMethod::query()->get();
    }

    public function getDriver(string $paymentDriver): PaymentDriver
    {
        return (new PaymentDriverFactory())->make($paymentDriver);
    }


    public function getPayment(string $payment_uuid): Payment
    {
        $payment = Payment::query()->where('uuid', $payment_uuid)->first();

        if ($payment === null) {
            throw new \Exception('Payment not found');
        }
        return $payment;
    }
}
