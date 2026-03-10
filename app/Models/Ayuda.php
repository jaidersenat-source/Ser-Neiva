<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ayuda extends Model
{
    use HasFactory;

    protected $table = 'ayudas';

    protected $fillable = [
        'nombre',
        'descripcion',
        'icono',
        'color',
    ];

    // ── Relación many-to-many con Iglesia ──────────────────────
    public function iglesias(): BelongsToMany
    {
        return $this->belongsToMany(
            Iglesia::class,
            'iglesia_ayuda',   // tabla pivote
            'ayuda_id',        // FK de este modelo en el pivote
            'iglesia_id'       // FK del modelo relacionado en el pivote
        )->withTimestamps();
    }

    // ── Accesors ───────────────────────────────────────────────
    public function getTotalIglesiasAttribute(): int
    {
        return $this->iglesias()->count();
    }
}