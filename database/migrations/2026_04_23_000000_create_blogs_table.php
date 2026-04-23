<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->string('extracto', 400)->nullable();
            $table->longText('contenido');
            $table->string('imagen')->nullable();
            $table->string('youtube_url', 500)->nullable();
            $table->boolean('publicado')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['publicado', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
