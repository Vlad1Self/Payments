<?php

namespace Tests\Feature\Order;

use App\Domain\Models\Payment\Enum\PaymentPayableEnum;
use App\Domain\Models\Payment\Enum\PaymentStatusEnum;
use App\Domain\Models\Payment\Payment;
use App\Infrastructure\Traits\TestTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;
    use TestTrait;

    public function test_index_orders_work()
    {
        $this->create_data();

        $response = $this->get('/api/orders/index/1');

        $response->assertStatus(200);
    }

    public function test_show_order_work()
    {
        $this->create_data();

        $order = $this->get_order();

        $response = $this->get('/api/orders/show/' . $order->uuid);

        $response->assertStatus(200);
    }

    public function test_store_order_work()
    {
        $this->create_data();

        $response = $this->post('/api/orders/store', [
            "currency_id" => "RUB",
            "price" => "100",
            "user_id" => 1
        ]);

        $response->assertStatus(200);
    }

    public function test_order_payment_work()
    {
        $this->create_data();

        $order = $this->get_order();

        $response = $this->post('/api/orders/payment/' . $order->uuid);

        $this->assertDatabaseHas('payments', [
            'currency_id' => $order->currency_id,
            'status' => PaymentStatusEnum::pending,
            'amount' => $order->price * env('COMMISSION', 1),
            'payable_id' => $order->id,
            'payable_type' => PaymentPayableEnum::order
        ]);

        $payment = Payment::query()->where('payable_id', $order->id)->first();

        $response->assertRedirect('api/payments/checkout/' . $payment->uuid);
    }
}
