<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Copiar datos legacy → columnas nuevas (solo donde la nueva esté vacía)
        DB::statement("
            UPDATE iglesias SET
                official_name    = COALESCE(NULLIF(official_name,''), nombre),
                denomination     = COALESCE(NULLIF(denomination,''), denominacion),
                address          = COALESCE(NULLIF(address,''), direccion),
                pastor_full_name = COALESCE(NULLIF(pastor_full_name,''), pastor_sacerdote),
                pastor_phone     = COALESCE(NULLIF(pastor_phone,''), telefono),
                phone_mobile     = COALESCE(NULLIF(phone_mobile,''), celular_institucional),
                email            = COALESCE(NULLIF(email,''), correo_institucional),
                approx_members   = COALESCE(approx_members, promedio_asistentes),
                pastor_birth_date= COALESCE(pastor_birth_date, fecha_nacimiento_lider),
                additional_notes = COALESCE(NULLIF(additional_notes,''), descripcion),
                church_status    = CASE
                    WHEN church_status IS NOT NULL AND church_status != '' THEN church_status
                    WHEN estado = 'activo' THEN 'Active'
                    ELSE 'Inactive'
                END
        ");

        // 2. Eliminar columnas legacy
        Schema::table('iglesias', function (Blueprint $table) {
            $table->dropColumn([
                'nombre',
                'denominacion',
                'direccion',
                'corregimiento',
                'pastor_sacerdote',
                'telefono',
                'celular_institucional',
                'correo_institucional',
                'estado',
                'promedio_asistentes',
                'fecha_nacimiento_lider',
                'descripcion',
                'entidad_registrada_colombia',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('iglesias', function (Blueprint $table) {
            $table->string('nombre', 200)->nullable()->default('')->after('id');
            $table->string('denominacion', 150)->nullable()->default('')->after('official_name');
            $table->string('direccion', 255)->nullable()->default('')->after('denomination');
            $table->string('corregimiento', 100)->nullable()->after('comuna');
            $table->string('pastor_sacerdote', 150)->nullable()->after('approx_members');
            $table->string('telefono', 20)->nullable()->after('pastor_sacerdote');
            $table->string('celular_institucional', 20)->nullable()->after('telefono');
            $table->string('correo_institucional', 150)->nullable()->after('celular_institucional');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo')->after('correo_institucional');
            $table->unsignedInteger('promedio_asistentes')->nullable()->after('estado');
            $table->date('fecha_nacimiento_lider')->nullable()->after('pastor_sacerdote');
            $table->text('descripcion')->nullable()->after('correo_institucional');
            $table->enum('entidad_registrada_colombia', ['SI', 'NO', 'EN_PROCESO'])->default('NO')->after('correo_institucional');
        });
    }
};
