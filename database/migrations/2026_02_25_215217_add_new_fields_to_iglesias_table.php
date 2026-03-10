<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('iglesias', function (Blueprint $table) {

            // ── SECCIÓN 1: Información básica ──────────────────────────
            $table->string('celular_institucional', 20)
                  ->nullable()
                  ->after('telefono')
                  ->comment('Celular de contacto institucional');

            $table->string('correo_institucional', 150)
                  ->nullable()
                  ->after('celular_institucional')
                  ->comment('Correo oficial de la iglesia');

            $table->enum('entidad_registrada_colombia', ['SI', 'NO', 'EN_PROCESO'])
                  ->default('NO')
                  ->after('correo_institucional')
                  ->comment('Registro ante entidades colombianas');

            $table->unsignedInteger('promedio_asistentes')
                  ->nullable()
                  ->after('entidad_registrada_colombia')
                  ->comment('Promedio de asistentes por servicio');

            // ── SECCIÓN 2: Contacto y responsable ─────────────────────
            $table->date('fecha_nacimiento_lider')
                  ->nullable()
                  ->after('pastor_sacerdote')
                  ->comment('Fecha de nacimiento del pastor/sacerdote/líder');
        });
    }

    public function down(): void
    {
        Schema::table('iglesias', function (Blueprint $table) {
            $table->dropColumn([
                'celular_institucional',
                'correo_institucional',
                'entidad_registrada_colombia',
                'promedio_asistentes',
                'fecha_nacimiento_lider',
            ]);
        });
    }
};