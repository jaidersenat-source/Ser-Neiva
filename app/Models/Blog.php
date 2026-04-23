<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'titulo',
        'slug',
        'extracto',
        'contenido',
        'imagen',
        'youtube_url',
        'publicado',
        'published_at',
    ];

    protected $casts = [
        'publicado'    => 'boolean',
        'published_at' => 'datetime',
    ];

    // ─── Relaciones ───────────────────────────────────────────────

    public function autor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // ─── Scopes ───────────────────────────────────────────────────

    public function scopePublicados($query)
    {
        return $query->where('publicado', true);
    }

    // ─── Helpers YouTube ──────────────────────────────────────────

    /**
     * Extrae el video ID de una URL de YouTube.
     * Soporta: watch?v=, youtu.be/, /embed/
     */
    public function youtubeId(): ?string
    {
        if (!$this->youtube_url) {
            return null;
        }

        $url = trim($this->youtube_url);
        $id  = null;

        // youtu.be/VIDEO_ID
        if (preg_match('/youtu\.be\/([a-zA-Z0-9_\-]{11})/', $url, $m)) {
            $id = $m[1];
        }
        // youtube.com/watch?v=VIDEO_ID
        elseif (preg_match('/[?&]v=([a-zA-Z0-9_\-]{11})/', $url, $m)) {
            $id = $m[1];
        }
        // youtube.com/embed/VIDEO_ID
        elseif (preg_match('/\/embed\/([a-zA-Z0-9_\-]{11})/', $url, $m)) {
            $id = $m[1];
        }

        return $id;
    }

    public function youtubeEmbedUrl(): ?string
    {
        $id = $this->youtubeId();
        return $id ? "https://www.youtube.com/embed/{$id}" : null;
    }
}
