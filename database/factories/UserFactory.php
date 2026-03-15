<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'username' => fake()->unique()->userName(),
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'user',
            'kelas' => fake()->randomElement(['X', 'XI', 'XII']),
            'jurusan' => fake()->randomElement(['Rekayasa Perangkat Lunak', 'Kecantikan', 'Tata Boga', 'Seni Musik', 'Usaha Layanan Wisata', 'Busana', 'Perhotelan']),
            'nomor_kendaraan' => strtoupper(fake()->bothify('B #### ???')),
            'jenis_kendaraan' => fake()->randomElement(['Motor', 'Mobil', 'Sepeda']),
            'qr_token' => (string) Str::uuid(),
            'remember_token' => Str::random(10),
        ];
    }
}
