<?php

namespace Tests\Feature\PaymentMethod;

use App\Domain\Models\Payment\Payment;
use App\Infrastructure\Traits\TestTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;
    use TestTrait;

    public function test_payment_methods_index_work(): void
    {
        $this->create_data();

        $response = $this->get('api/payment_methods/index');

        $response->assertStatus(200);
    }

    public function test_payment_methods_redirectPayment_work(): void
    {
        $this->create_data();

        $payment = Payment::query()->first();

        $response = $this->get('api/payment_methods/' . $payment->uuid . '/redirectPayment');

        $response->assertStatus(200);
    }
}
