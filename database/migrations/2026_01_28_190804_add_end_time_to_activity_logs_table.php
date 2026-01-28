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
    Schema::table('activity_logs', function (Blueprint $table) {
        $table->time('end_time')->nullable()->after('time'); // Add end_time column
    });
}

    public function down()
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropColumn('end_time');
        });
    }
};
