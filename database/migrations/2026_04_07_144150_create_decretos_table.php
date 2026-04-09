<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('decretos', function (Blueprint $table) {
            $table->id();
            $table->string('numero');          // Ej: "0510"
            $table->string('anio', 4);         // Ej: "2016"
            $table->string('title');           // Título completo
            $table->string('slug')->unique();  // URL amigable
            $table->text('summary')->nullable(); // Primer párrafo / descripción breve
            $table->longText('body');          // Texto completo del decreto
            $table->string('filename')->nullable(); // Nombre del PDF
            $table->date('published_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('decretos');
    }
};