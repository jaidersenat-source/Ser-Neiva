<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Iglesia extends Model
{
    use HasFactory;

    protected $table = 'iglesias';

    protected $fillable = [
        // ── Campos heredados (compatibilidad) ──────────────────────────────
        'nombre', 'denominacion', 'direccion', 'comuna', 'corregimiento',
        'estado', 'celular_institucional', 'correo_institucional',
        'entidad_registrada_colombia', 'promedio_asistentes',
        'pastor_sacerdote', 'fecha_nacimiento_lider', 'telefono',
        'email', 'descripcion',
        // ── Sección 1: Información de la Iglesia ──────────────────────
        'official_name',
        'denomination',
        'confessional_character',
        'church_status',
        'specific_location',
        'foundation_date',
        'approx_members',
        // ── Sección 2: Ubicación ─────────────────────────────────────
        'address',
        'neighborhood',        'municipality',        'city',
        'department',
        'country',
        // ── Sección 3: Contacto ─────────────────────────────────────
        'phone_landline',
        'phone_mobile',
        'website_or_social',
        // ── Sección 4: Pastor principal ────────────────────────────
        'pastor_full_name',
        'pastor_document_type',
        'pastor_document_number',
        'pastor_birth_date',
        'leadership_period_type',
        'pastor_phone',
        'pastor_email',
        // ── Sección 5: Líder de mujeres ────────────────────────────
        'women_leader_full_name',
        'women_leader_phone',
        'women_leader_email',
        // ── Sección 6: Datos jurídicos ────────────────────────────
        'legal_registration_type',
        'legal_registration_number',
        'legal_entity_granting',
        'resolution_number',
        'resolution_date',
        'file_number',
        'legal_personality_type',
        'legal_notes',
        // ── Sección 7 y 8 ─────────────────────────────────────────
        'ministries',
        'additional_notes',
        'schedule_weekdays',
        'schedule_weekends',
        // ── Mapa ────────────────────────────────────────────────
        'latitud',
        'longitud',
        // ── Foto ─────────────────────────────────────────────────
        'photo',
    ];

    protected $casts = [
        'latitud'                => 'float',
        'longitud'               => 'float',
        'promedio_asistentes'    => 'integer',
        'approx_members'         => 'integer',
        'fecha_nacimiento_lider' => 'date',
        'foundation_date'        => 'date',
        'pastor_birth_date'      => 'date',
        'resolution_date'        => 'date',
        'ministries'             => 'array',
    ];

       public const ENTIDAD_OPCIONES = [
        'SI'         => 'Sí, registrada',
        'NO'         => 'No registrada',
        'EN_PROCESO' => 'En proceso',
    ];

    // ── Scopes ────────────────────────────────────────────────
    public function scopeActivas($query)
    {
        return $query->where('estado', 'activo');
    }

     /**
     * Calcula la edad del líder a partir de su fecha de nacimiento.
     * Retorna null si no hay fecha registrada.
     */
    public function getEdadLiderAttribute(): ?int
    {
        return $this->fecha_nacimiento_lider
            ? $this->fecha_nacimiento_lider->age
            : null;
    }

    /**
     * Etiqueta legible del estado de registro en Colombia.
     */
    public function getEntidadLabelAttribute(): string
    {
        return self::ENTIDAD_OPCIONES[$this->entidad_registrada_colombia] ?? 'No registrada';
    }

     public function isActiva(): bool
    {
        return $this->estado === 'activo';
    }

    // ── Relación many-to-many con Ayuda ───────────────────────
    public function ayudas(): BelongsToMany
    {
        return $this->belongsToMany(
            Ayuda::class,
            'iglesia_ayuda',   // tabla pivote
            'iglesia_id',      // FK de este modelo en el pivote
            'ayuda_id'         // FK del modelo relacionado en el pivote
        )->withTimestamps();
    }

    public function eventos()
{
    return $this->hasMany(Evento::class);
}

}