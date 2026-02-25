<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('siswa')) {
            return;
        }

        Schema::create('siswa', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nama_siswa', 100);
            $table->string('kelas', 20);
            $table->enum('jurusan', [
                'Rekayasa Perangkat Lunak',
                'Kecantikan',
                'Tata Boga',
                'Seni Musik',
                'Usaha Layanan Wisata',
                'Busana',
                'Perhotelan',
            ]);
            $table->timestamp('created_at')->useCurrent();
            $table->index('kelas');
            $table->index('jurusan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
