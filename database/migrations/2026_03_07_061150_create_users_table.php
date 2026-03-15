<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('username')->unique();
                $table->string('name');
                $table->string('email')->default('')->unique();
                $table->string('password');
                $table->string('role')->default('user');
                $table->string('kelas')->nullable();
                $table->string('jurusan')->nullable();
                $table->string('nomor_kendaraan')->nullable()->unique();
                $table->string('jenis_kendaraan')->nullable();
                $table->string('qr_token')->nullable()->unique();
                $table->rememberToken();
                $table->timestamps();
            });

            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'username')) {
                $table->string('username')->nullable()->unique()->after('id');
            }
            if (! Schema::hasColumn('users', 'name')) {
                $table->string('name')->nullable()->after('username');
            }
            if (! Schema::hasColumn('users', 'email')) {
                $table->string('email')->default('')->unique()->after('name');
            }
            if (! Schema::hasColumn('users', 'password')) {
                $table->string('password')->nullable()->after('email');
            }
            if (! Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('user')->after('password');
            }
            if (! Schema::hasColumn('users', 'kelas')) {
                $table->string('kelas')->nullable()->after('role');
            }
            if (! Schema::hasColumn('users', 'jurusan')) {
                $table->string('jurusan')->nullable()->after('kelas');
            }
            if (! Schema::hasColumn('users', 'nomor_kendaraan')) {
                $table->string('nomor_kendaraan')->nullable()->unique()->after('jurusan');
            }
            if (! Schema::hasColumn('users', 'jenis_kendaraan')) {
                $table->string('jenis_kendaraan')->nullable()->after('nomor_kendaraan');
            }
            if (! Schema::hasColumn('users', 'qr_token')) {
                $table->string('qr_token')->nullable()->unique()->after('jenis_kendaraan');
            }
            if (! Schema::hasColumn('users', 'remember_token')) {
                $table->rememberToken();
            }
            if (! Schema::hasColumn('users', 'created_at') || ! Schema::hasColumn('users', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
