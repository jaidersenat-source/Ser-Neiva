<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iglesia_ayuda', function (Blueprint $table) {
            $table->id();
            $table->foreignId('iglesia_id')
                  ->constrained('iglesias')
                  ->cascadeOnDelete();
            $table->foreignId('ayuda_id')
                  ->constrained('ayudas')
                  ->cascadeOnDelete();
            $table->timestamps();

            // Evitar duplicados en la relación
            $table->unique(['iglesia_id', 'ayuda_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iglesia_ayuda');
    }
};