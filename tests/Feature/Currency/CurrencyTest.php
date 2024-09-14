<?php

namespace Tests\Feature\Currency;

use App\Infrastructure\Traits\TestTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CurrencyTest extends TestCase
{
    use RefreshDatabase;
    use TestTrait;
    public function test_index_currency_work(): void
    {
        $this->create_data();

        $response = $this->get('/api/currencies/index');

        $response->assertStatus(200);
    }
}
