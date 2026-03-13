<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Eliminar tabla dependiente primero
        Schema::dropIfExists('campaign_recipients');

        // Recrear con iglesia_id en lugar de contact_id
        Schema::create('campaign_recipients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->cascadeOnDelete();
            $table->foreignId('iglesia_id')->constrained('iglesias')->cascadeOnDelete();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->unique(['campaign_id', 'iglesia_id']);
        });

        // Ya no se necesita la tabla contacts
        Schema::dropIfExists('campaign_images'); // la recreamos limpia también
        Schema::create('campaign_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('campaign_id')->constrained()->cascadeOnDelete();
            $table->string('path');
            $table->string('original_name', 255)->nullable();
            $table->timestamps();
        });

        Schema::dropIfExists('contacts');
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_recipients');
        Schema::dropIfExists('campaign_images');
    }
};
