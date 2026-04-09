<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Emprendimiento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'emprendimientos';

    protected $fillable = [
        'iglesia_id',
        'user_id',
        'nombre',
        'slug',
        'descripcion',
        'categoria',
        'latitud',
        'longitud',
        'telefono',
        'email',
        'direccion',
        'web',
        'horario',
        'imagen_principal',
        'imagenes',
        'verificado',
        'activo',
    ];

    protected $casts = [
        'imagenes'  => 'array',
        'verificado' => 'boolean',
        'activo'     => 'boolean',
        'latitud'    => 'float',
        'longitud'   => 'float',
    ];

    protected static function booted()
    {
        static::creating(function (Emprendimiento $model) {
            if (empty($model->slug) && !empty($model->nombre)) {
                $base = Str::slug($model->nombre);
                $slug = $base;
                $i = 1;
                while (self::where('slug', $slug)->exists()) {
                    $slug = $base . '-' . $i++;
                }
                $model->slug = $slug;
            }
        });
    }

    public function iglesia(): BelongsTo
    {
        return $this->belongsTo(Iglesia::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}
