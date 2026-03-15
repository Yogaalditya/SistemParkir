<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator Parkir',
                'email' => 'admin@parkir-sekolah.local',
                'password' => 'parkirsekolahskenpat22',
                'role' => 'admin',
                'qr_token' => (string) Str::uuid(),
            ]
        );
    }
}
