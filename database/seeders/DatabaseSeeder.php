<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name'     => 'Admin',
                'password' => '12345678',   // texto plano: el cast 'hashed' la encripta
                'rol'      => 'admin',
                'activo'   => true,
            ]
        );
    }
}
