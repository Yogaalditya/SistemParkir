<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kendaraan extends Model
{
    protected $table = 'kendaraan';

    protected $fillable = [
        'siswa_id',
        'nomor_kendaraan',
        'jenis_kendaraan',
    ];

    public $timestamps = false;

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function tempatParkir(): HasMany
    {
        return $this->hasMany(TempatParkir::class, 'kendaraan_id');
    }
}
