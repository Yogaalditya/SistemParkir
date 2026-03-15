<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'role',
        'kelas',
        'jurusan',
        'nomor_kendaraan',
        'jenis_kendaraan',
        'qr_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    public function parkingSessions(): HasMany
    {
        return $this->hasMany(ParkingSession::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
