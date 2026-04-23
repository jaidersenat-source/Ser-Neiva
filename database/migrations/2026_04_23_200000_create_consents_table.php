<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained()
                  ->nullOnDelete();
            $table->foreignId('church_request_id')
                  ->nullable()
                  ->constrained('church_requests')
                  ->nullOnDelete();
            // privacy_policy | terms_conditions | registration
            $table->string('type', 50);
            $table->string('version', 20);
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('accepted_at')->useCurrent();
            $table->timestamps();

            $table->index(['user_id', 'type', 'version'], 'consents_user_type_version_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consents');
    }
};
