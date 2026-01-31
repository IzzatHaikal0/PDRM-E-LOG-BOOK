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
            // Adding columns from the ERD that don't exist yet
            $table->string('no_badan')->nullable()->unique()->after('id'); // Badge No
            $table->string('no_ic')->nullable()->unique()->after('name'); // IC No
            $table->string('no_telefon')->nullable()->after('no_ic'); // Phone No
            
            // 'alamat' (Address)
            $table->text('alamat')->nullable()->after('email'); 
            
            // 'umur' (Age)
            $table->integer('umur')->nullable()->after('alamat');
            
            // 'pangkat_id' (Foreign Key for Rank)
            // Storing as unsignedBigInteger to match standard ID types
            $table->unsignedBigInteger('pangkat_id')->nullable()->after('umur');
            
            // 'gambar_profile' (Profile Picture Path)
            $table->string('gambar_profile')->nullable()->after('pangkat_id');

            // Optional: If you have a 'pangkats' table, you can enable this relation:
            // $table->foreign('pangkat_id')->references('id')->on('pangkats')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'no_badan',
                'no_ic',
                'no_telefon',
                'alamat',
                'umur',
                'pangkat_id',
                'gambar_profile',
            ]);
        });
    }
};