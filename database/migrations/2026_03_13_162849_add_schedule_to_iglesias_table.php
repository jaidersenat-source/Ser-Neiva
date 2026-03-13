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
        Schema::table('iglesias', function (Blueprint $table) {
            $table->string('schedule_weekdays', 100)->nullable()->after('additional_notes');
            $table->string('schedule_weekends', 100)->nullable()->after('schedule_weekdays');
        });
    }

    public function down(): void
    {
        Schema::table('iglesias', function (Blueprint $table) {
            $table->dropColumn(['schedule_weekdays', 'schedule_weekends']);
        });
    }
};
