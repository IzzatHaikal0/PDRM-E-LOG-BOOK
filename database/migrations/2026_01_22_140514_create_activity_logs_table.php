<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            
            // 1. Who created this log? (The Anggota)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // 2. Form Data
            $table->string('balai');          // Balai Bertugas (Snapshot)
            $table->string('area');           // Kawasan Penugasan (Sektor A, B, etc)
            $table->string('type');           // Jenis (Rondaan, Pejabat, etc)
            $table->date('date');             // Tarikh
            $table->time('time');             // Masa
            $table->text('remarks')->nullable(); // Catatan

            // 3. Approval System
            // Who is the supervisor responsible? (Links to users table too)
            $table->foreignId('officer_id')->constrained('users')->onDelete('cascade');
            
            // Status: pending, approved, rejected
            $table->string('status')->default('pending');
            
            // If rejected, why?
            $table->string('rejection_reason')->nullable();

            $table->timestamps(); // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};