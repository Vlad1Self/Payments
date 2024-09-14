<?php

namespace Database\Seeders;

use App\Domain\Models\User\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->make_test_user();

        if (User::query()->count() < 100) {
            User::factory()->count(100)->create();
        }
    }

    private function make_test_user(): void
    {
        User::query()->firstOrCreate([
            'name' => 'Test User',
        ], [
            'email' => 'test@example.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        ]);
    }
}
