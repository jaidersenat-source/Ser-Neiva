<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Decreto extends Model
{
    protected $fillable = [
        'numero', 'anio', 'title', 'slug',
        'summary', 'body', 'filename', 'published_at',
    ];

    protected $casts = [
        'published_at' => 'date',
    ];
}