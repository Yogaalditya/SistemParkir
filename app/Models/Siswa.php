<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Siswa extends Model
{
    protected $table = 'siswa';

    protected $fillable = [
        'nama_siswa',
        'kelas',
        'jurusan',
    ];

    public $timestamps = false;

    public function kendaraan(): HasMany
    {
        return $this->hasMany(Kendaraan::class, 'siswa_id');
    }

    public function tempatParkir(): HasMany
    {
        return $this->hasMany(TempatParkir::class, 'siswa_id');
    }
}
