<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('tempat_parkir')) {
            return;
        }

        Schema::create('tempat_parkir', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('kendaraan_id');
            $table->unsignedInteger('siswa_id');
            $table->dateTime('jam_masuk');
            $table->dateTime('jam_keluar')->nullable();
            $table->date('tanggal_parkir');
            $table->timestamp('created_at')->useCurrent();
            $table->index('kendaraan_id');
            $table->index('siswa_id');
            $table->index('jam_masuk');
            $table->index('jam_keluar');
            $table->index('tanggal_parkir');
            $table->foreign('kendaraan_id')->references('id')->on('kendaraan')->onDelete('cascade');
            $table->foreign('siswa_id')->references('id')->on('siswa')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tempat_parkir');
    }
};
