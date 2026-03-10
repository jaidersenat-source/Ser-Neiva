<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('iglesias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 200);
            $table->string('denominacion', 150);
            $table->string('direccion', 255);
            $table->string('comuna', 100)->nullable();
            $table->string('corregimiento', 100)->nullable();
            $table->decimal('latitud', 10, 8);
            $table->decimal('longitud', 11, 8);
            $table->string('pastor_sacerdote', 150)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('email', 150)->nullable();
            $table->text('descripcion')->nullable();
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iglesias');
    }
};