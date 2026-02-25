<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TempatParkir extends Model
{
    protected $table = 'tempat_parkir';

    protected $fillable = [
        'kendaraan_id',
        'siswa_id',
        'jam_masuk',
        'jam_keluar',
        'tanggal_parkir',
    ];

    public $timestamps = false;

    protected $casts = [
        'jam_masuk' => 'datetime',
        'jam_keluar' => 'datetime',
        'tanggal_parkir' => 'date',
    ];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function kendaraan(): BelongsTo
    {
        return $this->belongsTo(Kendaraan::class, 'kendaraan_id');
    }
}
