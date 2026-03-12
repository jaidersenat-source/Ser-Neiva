<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('iglesias', function (Blueprint $table) {
            // Sección 1 — Información
            $table->string('official_name', 200)->nullable()->after('nombre');
            $table->string('denomination', 50)->nullable()->after('denominacion');
            $table->string('confessional_character', 50)->nullable()->after('denomination');
            $table->string('church_status', 20)->nullable()->after('estado');
            $table->string('specific_location', 255)->nullable()->after('church_status');
            $table->date('foundation_date')->nullable()->after('specific_location');
            $table->unsignedInteger('approx_members')->nullable()->after('promedio_asistentes');
            // Sección 2 — Ubicación
            $table->string('address', 255)->nullable()->after('direccion');
            $table->string('neighborhood', 100)->nullable()->after('address');
            $table->string('city', 100)->nullable()->after('neighborhood');
            $table->string('department', 100)->nullable()->after('city');
            $table->string('country', 80)->nullable()->default('Colombia')->after('department');
            // Sección 3 — Contacto
            $table->string('phone_landline', 20)->nullable()->after('celular_institucional');
            $table->string('phone_mobile', 20)->nullable()->after('phone_landline');
            $table->string('website_or_social', 255)->nullable()->after('correo_institucional');
            // Sección 4 — Pastor
            $table->string('pastor_full_name', 150)->nullable()->after('pastor_sacerdote');
            $table->string('pastor_document_type', 20)->nullable()->after('pastor_full_name');
            $table->string('pastor_document_number', 30)->nullable()->after('pastor_document_type');
            $table->date('pastor_birth_date')->nullable()->after('pastor_document_number');
            $table->string('leadership_period_type', 30)->nullable()->after('pastor_birth_date');
            $table->string('pastor_phone', 20)->nullable()->after('telefono');
            $table->string('pastor_email', 150)->nullable()->after('pastor_phone');
            // Sección 5 — Líder de mujeres
            $table->string('women_leader_full_name', 150)->nullable()->after('pastor_email');
            $table->string('women_leader_phone', 20)->nullable()->after('women_leader_full_name');
            $table->string('women_leader_email', 150)->nullable()->after('women_leader_phone');
            // Sección 6 — Datos jurídicos
            $table->string('legal_registration_type', 80)->nullable()->after('women_leader_email');
            $table->string('legal_registration_number', 50)->nullable()->after('legal_registration_type');
            $table->string('legal_entity_granting', 200)->nullable()->after('legal_registration_number');
            $table->string('resolution_number', 80)->nullable()->after('legal_entity_granting');
            $table->date('resolution_date')->nullable()->after('resolution_number');
            $table->string('file_number', 80)->nullable()->after('resolution_date');
            $table->string('legal_personality_type', 30)->nullable()->after('file_number');
            $table->text('legal_notes')->nullable()->after('legal_personality_type');
            // Sección 7 & 8
            $table->json('ministries')->nullable()->after('legal_notes');
            $table->text('additional_notes')->nullable()->after('ministries');
        });
    }

    public function down(): void
    {
        Schema::table('iglesias', function (Blueprint $table) {
            $table->dropColumn([
                'official_name', 'denomination', 'confessional_character', 'church_status',
                'specific_location', 'foundation_date', 'approx_members',
                'address', 'neighborhood', 'city', 'department', 'country',
                'phone_landline', 'phone_mobile', 'website_or_social',
                'pastor_full_name', 'pastor_document_type', 'pastor_document_number',
                'pastor_birth_date', 'leadership_period_type', 'pastor_phone', 'pastor_email',
                'women_leader_full_name', 'women_leader_phone', 'women_leader_email',
                'legal_registration_type', 'legal_registration_number', 'legal_entity_granting',
                'resolution_number', 'resolution_date', 'file_number', 'legal_personality_type',
                'legal_notes', 'ministries', 'additional_notes',
            ]);
        });
    }
};
