<?php

namespace App\Application\Services\PaymentMethod\Driver;

use App\Application\Services\PaymentMethod\DTO\RedirectPaymentDTO;
use App\Domain\Models\Payment\Payment;

class TestDriver extends PaymentDriver
{
    public function createPayment(string $payment_uuid): Payment
    {
        $driver_payment_uuid = uuid_create();

        /** @var Payment $payment */
        $payment = Payment::query()->where('uuid', $payment_uuid)->first();
        $payment->driver_payment_id = $driver_payment_uuid;
        $payment->save();

        return $payment;
    }

    public function redirect(Payment $payment): RedirectPaymentDTO
    {
        $data = new RedirectPaymentDTO(['payment_uuid' => $payment->uuid, 'driver_payment_uuid' => $payment->driver_payment_id, 'url' => '']);

        match ($payment->paymentMethod->currency_id) {
            'USD' => $data->url = 'https://response_for_usd.com',
            'RUB' => $data->url = 'https://response_for_rub.com',
            default => throw new \Exception('Invalid currency'),
        };

        return $data;
    }
}
