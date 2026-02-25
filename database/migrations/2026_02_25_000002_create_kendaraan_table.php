<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('kendaraan')) {
            return;
        }

        Schema::create('kendaraan', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('siswa_id');
            $table->string('nomor_kendaraan', 20)->unique();
            $table->enum('jenis_kendaraan', ['Motor', 'Mobil', 'Sepeda']);
            $table->timestamp('created_at')->useCurrent();
            $table->index('siswa_id');
            $table->index('nomor_kendaraan');
            $table->index('jenis_kendaraan');
            $table->foreign('siswa_id')->references('id')->on('siswa')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kendaraan');
    }
};
