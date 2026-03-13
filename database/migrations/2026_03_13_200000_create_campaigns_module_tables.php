<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('email', 150);
            $table->string('church_name', 200)->nullable();
            $table->string('city', 100)->nullable();
            $table->timestamps();

            $table->index('city');
            $table->index('email');
        });

        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->string('subject', 255);
            $table->longText('message');
            $table->enum('filter_type', ['all', 'city', 'selected'])->default('all');
            $table->string('city', 100)->nullable();
            $table->enum('status', ['draft', 'sent'])->default('draft');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });

        Schema::create('campaign_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->string('original_name', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('campaign_recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->cascadeOnDelete();
            $table->foreignId('contact_id')->constrained()->cascadeOnDelete();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->unique(['campaign_id', 'contact_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_recipients');
        Schema::dropIfExists('campaign_images');
        Schema::dropIfExists('campaigns');
        Schema::dropIfExists('contacts');
    }
};
