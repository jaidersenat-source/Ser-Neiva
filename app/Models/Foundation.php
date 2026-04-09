<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foundation extends Model
{
    protected $fillable = [
        'name',
        'nit',
        'representative',
        'document',
        'phone',
        'email',
        'address',
        'latitude',
        'longitude',
        'imagen_principal',
    ];

    protected $casts = [
        'latitude'  => 'float',
        'longitude' => 'float',
    ];
}
