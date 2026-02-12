<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pangkats', function (Blueprint $table) {
            // 'level' determines the order.
            $table->integer('level')->default(99); 
            
            // This creates a TIMESTAMP column named 'deleted_at'
            $table->softDeletes('deleted_at'); 
        });
    }

    public function down()
    {
        Schema::table('pangkats', function (Blueprint $table) {
            $table->dropColumn('level');
            
            // This drops the 'deleted_at' column
            $table->dropSoftDeletes('deleted_at');
        });
    }
};
