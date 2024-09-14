<?php

namespace Tests\Feature\User;

use App\Infrastructure\Traits\TestTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use TestTrait;

    public function test_index_users_work()
    {
        $this->create_data();

        $response = $this->get('/api/users/index/1');

        $response->assertStatus(200);
    }

    public function test_show_user_work()
    {
        $this->create_data();

        $response = $this->get('/api/users/show/1');

        $response->assertStatus(200);
    }
}
