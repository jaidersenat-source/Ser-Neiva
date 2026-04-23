<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('church_requests', function (Blueprint $table) {
            $table->boolean('consent_accepted')->default(false)->after('motivo_rechazo');
            $table->string('consent_version', 20)->nullable()->after('consent_accepted');
            $table->string('consent_ip', 45)->nullable()->after('consent_version');
            $table->timestamp('consent_accepted_at')->nullable()->after('consent_ip');
        });
    }

    public function down(): void
    {
        Schema::table('church_requests', function (Blueprint $table) {
            $table->dropColumn(['consent_accepted', 'consent_version', 'consent_ip', 'consent_accepted_at']);
        });
    }
};
