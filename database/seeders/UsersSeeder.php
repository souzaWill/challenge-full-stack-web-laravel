<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->admin()->create([
            'name' => 'admin',
            'email' => 'admin@maisaedu.com.br',
            'password' => 'youshouldnotpass',
        ]);
    }
}
