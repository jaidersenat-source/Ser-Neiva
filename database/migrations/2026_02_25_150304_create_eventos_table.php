<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('eventos', function (Blueprint $table) {
        $table->id();
        $table->foreignId('iglesia_id')->constrained()->onDelete('cascade');
        $table->string('titulo');
        $table->text('descripcion')->nullable();
        $table->dateTime('fecha_inicio');
        $table->dateTime('fecha_fin')->nullable();
        $table->string('direccion_evento');
        $table->decimal('latitud', 10, 7);
        $table->decimal('longitud', 10, 7);
        $table->string('tipo_evento');
        $table->string('estado')->default('activo');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos');
    }
};
