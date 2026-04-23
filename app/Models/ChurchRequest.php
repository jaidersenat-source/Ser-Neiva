<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChurchRequest extends Model
{
    protected $fillable = [
        'nombre_organizacion',
        'lider_religioso',
        'telefono',
        'direccion',
        'email',
        'estado',
        'notas_admin',
        'motivo_rechazo',
        'consent_accepted',
        'consent_version',
        'consent_ip',
        'consent_accepted_at',
    ];

    protected $casts = [
        'consent_accepted'    => 'boolean',
        'consent_accepted_at' => 'datetime',
    ];

    public function estadoBadge(): string
    {
        return match($this->estado) {
            'pendiente'  => '<span style="background:rgba(245,158,11,.15);color:#f59e0b;padding:.2rem .6rem;border-radius:6px;font-size:.72rem;font-weight:700;">Pendiente</span>',
            'revisada'   => '<span style="background:rgba(59,130,246,.15);color:#60a5fa;padding:.2rem .6rem;border-radius:6px;font-size:.72rem;font-weight:700;">Revisada</span>',
            'aprobada'   => '<span style="background:rgba(34,197,94,.15);color:#4ade80;padding:.2rem .6rem;border-radius:6px;font-size:.72rem;font-weight:700;">Aprobada</span>',
            'rechazada'  => '<span style="background:rgba(239,68,68,.15);color:#f87171;padding:.2rem .6rem;border-radius:6px;font-size:.72rem;font-weight:700;">Rechazada</span>',
            default      => $this->estado,
        };
    }
}
