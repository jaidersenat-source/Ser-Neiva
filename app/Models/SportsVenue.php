<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SportsVenue extends Model
{
    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'contact',
        'available_for_churches',
        'imagen_principal',
    ];

    protected $casts = [
        'latitude'               => 'decimal:7',
        'longitude'              => 'decimal:7',
        'available_for_churches' => 'boolean',
    ];
}
