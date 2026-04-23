<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('church_requests', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_organizacion');
            $table->string('lider_religioso');
            $table->string('telefono', 30);
            $table->string('direccion');
            $table->string('email');
            $table->enum('estado', ['pendiente', 'revisada', 'aprobada', 'rechazada'])->default('pendiente');
            $table->text('notas_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('church_requests');
    }
};
