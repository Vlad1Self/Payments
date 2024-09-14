<?php

namespace App\Application\Services\PaymentMethod\Driver;

use App\Application\Services\PaymentMethod\DTO\RedirectPaymentDTO;
use App\Domain\Models\Payment\Payment;

abstract class PaymentDriver
{
    abstract public function createPayment(string $payment_uuid): Payment;

    abstract public function redirect(Payment $payment): RedirectPaymentDTO;
}
