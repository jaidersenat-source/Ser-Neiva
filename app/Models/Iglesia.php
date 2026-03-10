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
         // ── Información básica ────────────────────────────────
        'nombre',
        'denominacion',
        'direccion',
        'comuna',
        'corregimiento',
        'estado',
        'celular_institucional',
        'correo_institucional',
        'entidad_registrada_colombia',
        'promedio_asistentes',
        'pastor_sacerdote',
        'fecha_nacimiento_lider',       // ← nuevo
        'telefono',
        'email',
        'descripcion',
        'latitud',
        'longitud',
    ];

    protected $casts = [
        'latitud'                => 'float',
        'longitud'               => 'float',
        'promedio_asistentes'    => 'integer',
        'fecha_nacimiento_lider' => 'date',     // Carbon automático
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