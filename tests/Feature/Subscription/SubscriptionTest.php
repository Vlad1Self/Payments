<?php

namespace Tests\Feature\Subscription;

use App\Infrastructure\Traits\TestTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;
    use TestTrait;

    public function test_subscription_index_work()
    {
        $this->create_data();

        $response = $this->get('api/subscriptions/index/1');

        $response->assertStatus(200);
    }

    public function test_subscription_show_work()
    {
        $this->create_data();

        $subscription = $this->get_subscription();

        $response = $this->get('api/subscriptions/show/' . $subscription->uuid);

        $response->assertStatus(200);
    }

    public function test_subscription_payment_work()
    {
        $this->create_data();

        $subscription = $this->get_subscription();

        $response = $this->post('api/subscriptions/payment/' . $subscription->uuid);

        $response->assertStatus(302);
    }
}
