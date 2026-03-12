<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('iglesias', function (Blueprint $table) {
            // Las columnas heredadas ya no son obligatorias en el formulario actual.
            // Se hacen nullable con default '' para no romper registros existentes.
            $table->string('nombre', 200)->nullable()->default('')->change();
            $table->string('denominacion', 150)->nullable()->default('')->change();
            $table->string('direccion', 255)->nullable()->default('')->change();
        });
    }

    public function down(): void
    {
        Schema::table('iglesias', function (Blueprint $table) {
            $table->string('nombre', 200)->nullable(false)->default(null)->change();
            $table->string('denominacion', 150)->nullable(false)->default(null)->change();
            $table->string('direccion', 255)->nullable(false)->default(null)->change();
        });
    }
};
