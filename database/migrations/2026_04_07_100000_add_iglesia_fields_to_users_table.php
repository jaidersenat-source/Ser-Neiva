<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Username para login de iglesias (sin formato email)
            $table->string('username')->unique()->nullable()->after('name');

            // Rol del usuario: 'admin' o 'iglesia'
            // La columna 'role' ya existe (migración 2026_03_12), solo ajustamos default via update
            // Añadir FK a iglesias para usuarios tipo 'iglesia'
            $table->foreignId('iglesia_id')
                  ->nullable()
                  ->after('role')
                  ->constrained('iglesias')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['iglesia_id']);
            $table->dropColumn(['username', 'iglesia_id']);
        });
    }
};
