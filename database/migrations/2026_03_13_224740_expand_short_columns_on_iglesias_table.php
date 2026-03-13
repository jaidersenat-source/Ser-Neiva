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
            $table->string('pastor_document_type', 100)->nullable()->change();
            $table->string('denomination', 150)->nullable()->change();
            $table->string('confessional_character', 150)->nullable()->change();
            $table->string('leadership_period_type', 100)->nullable()->change();
            $table->string('legal_personality_type', 100)->nullable()->change();
            $table->string('church_status', 50)->nullable()->change();
            $table->string('legal_registration_type', 200)->nullable()->change();
            $table->string('schedule_weekdays', 255)->nullable()->change();
            $table->string('schedule_weekends', 255)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('iglesias', function (Blueprint $table) {
            $table->string('pastor_document_type', 20)->nullable()->change();
            $table->string('denomination', 50)->nullable()->change();
            $table->string('confessional_character', 50)->nullable()->change();
            $table->string('leadership_period_type', 30)->nullable()->change();
            $table->string('legal_personality_type', 30)->nullable()->change();
            $table->string('church_status', 20)->nullable()->change();
            $table->string('legal_registration_type', 80)->nullable()->change();
            $table->string('schedule_weekdays', 100)->nullable()->change();
            $table->string('schedule_weekends', 100)->nullable()->change();
        });
    }
};
