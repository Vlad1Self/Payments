<?php

namespace Tests\Feature\Payment;

use App\Domain\Models\Payment\Enum\PaymentStatusEnum;
use App\Domain\Models\Payment\Payment;
use App\Infrastructure\Traits\TestTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PaymentTest extends TestCase
{
    use RefreshDatabase;
    use TestTrait;

    public function test_payment_index_work()
    {
        $this->create_data();

        $response = $this->get('/api/payments/index/1');

        $response->assertStatus(200);
    }

    public function test_payment_checkout_work()
    {
        $this->create_data();

        $payment = Payment::query()->first();

        $response = $this->get('/api/payments/checkout/' . $payment->uuid);

        $response->assertStatus(200);
    }

    public function test_payment_choose_work()
    {
        $this->create_data();

        $payment = Payment::query()->first();

        $response = $this->post('/api/payments/choose/' . $payment->uuid, [
            'payment_method_id' => 1
        ]);

        $response->assertRedirect('/api/payments/process/' . $payment->uuid);
    }

    public function test_payment_process_work()
    {
        $this->create_data();

        $payment = Payment::query()->first();

        $response = $this->get('/api/payments/process/' . $payment->uuid);

        $response->assertStatus(302);

        $this->assertDatabaseHas('payments', [
            'uuid' => $payment->uuid,
            'status' => PaymentStatusEnum::processing
        ]);
    }
}
