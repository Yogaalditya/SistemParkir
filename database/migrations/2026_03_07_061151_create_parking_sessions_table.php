<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('parking_sessions')) {
            return;
        }

        Schema::create('parking_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('public_token')->unique();
            $table->dateTime('checked_in_at');
            $table->dateTime('paid_at')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('payment_status')->default('pending');
            $table->unsignedInteger('base_fee')->default(2000);
            $table->dateTime('checked_out_at')->nullable();
            $table->foreignId('admin_confirmed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parking_sessions');
    }
};
