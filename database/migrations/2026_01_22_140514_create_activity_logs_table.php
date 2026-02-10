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
            
            // 1. Who created this log?
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // 2. Form Data
            $table->string('balai')->nullable(); // Made nullable to prevent crash if user profile is empty
            $table->string('area');              // Kawasan Penugasan
            $table->string('type');              // Jenis Penugasan
            $table->date('date');                // Tarikh
            $table->time('time');                // Masa Mula
            $table->time('end_time')->nullable(); // Added: Masa Tamat
            
            // Fixed: Changed from time() to boolean()
            $table->boolean('is_off_duty')->default(false);
            
            $table->text('remarks')->nullable(); // Catatan

            // Added: Store images as JSON array ["img1.jpg", "img2.jpg"]
            $table->json('images')->nullable();

            // 3. Approval System
            // Fixed: Made nullable() because officer is not selected during creation anymore
            $table->foreignId('officer_id')->nullable()->constrained('users')->onDelete('cascade');
            
            // Status: ongoing, pending, approved, rejected
            $table->string('status',['draft', 'pending', 'approved', 'rejected'])->default('draft');
            
            // If rejected, why?
            $table->string('rejection_reason')->nullable();

            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};