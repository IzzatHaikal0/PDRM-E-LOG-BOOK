<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penugasan', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // The task name (e.g., Rondaan MPV)
            $table->string('description')->nullable(); // Optional description
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penugasan');
    }
};