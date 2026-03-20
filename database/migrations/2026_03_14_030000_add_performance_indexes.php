<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('iglesias', function (Blueprint $table) {
            $table->index('church_status');
            $table->index('municipality');
            $table->index('denomination');
            $table->index('city');
        });

        Schema::table('eventos', function (Blueprint $table) {
            $table->index('estado');
            $table->index('fecha_inicio');
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('iglesias', function (Blueprint $table) {
            $table->dropIndex(['church_status']);
            $table->dropIndex(['municipality']);
            $table->dropIndex(['denomination']);
            $table->dropIndex(['city']);
        });

        Schema::table('eventos', function (Blueprint $table) {
            $table->dropIndex(['estado']);
            $table->dropIndex(['fecha_inicio']);
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });
    }
};
