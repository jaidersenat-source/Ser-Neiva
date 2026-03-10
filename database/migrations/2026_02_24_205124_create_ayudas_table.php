<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ayudas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 150);
            $table->text('descripcion')->nullable();
            $table->string('icono', 10)->nullable()->comment('Emoji o código de icono');
            $table->string('color', 7)->default('#3B82F6')->comment('Color hex para UI');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ayudas');
    }
};