<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $fillable = [
        'iglesia_id', 'titulo', 'descripcion', 'fecha_inicio', 'fecha_fin',
        'direccion_evento', 'latitud', 'longitud', 'tipo_evento', 'estado',
        'imagen_principal'
    ];

    public function iglesia()
    {
        return $this->belongsTo(Iglesia::class);
    }

    // App/Models/Evento.php
protected $casts = [
    'fecha_inicio' => 'datetime',
    'fecha_fin'    => 'datetime',
];
}