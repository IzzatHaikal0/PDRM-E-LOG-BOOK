<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // This tells MySQL: "pangkat_id in users table MUST exist in pangkats table id"
            $table->foreign('pangkat_id')
                ->references('id')
                ->on('pangkats')
                ->nullOnDelete(); // If a rank is deleted, set user's rank to NULL (safer than deleting the user)
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['pangkat_id']);
        });
    }
};
