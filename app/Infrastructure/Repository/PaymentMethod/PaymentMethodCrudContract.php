<?php

namespace App\Infrastructure\Repository\PaymentMethod;

use App\Application\Services\PaymentMethod\Driver\PaymentDriver;
use App\Domain\Models\Payment\Payment;
use App\Domain\Models\PaymentMethod\PaymentMethod;
use Illuminate\Database\Eloquent\Collection;

interface PaymentMethodCrudContract
{
    public function index(): Collection;

    public function getPayment(string $payment_uuid): Payment;

    public function getDriver(string $paymentDriver): PaymentDriver;
}
