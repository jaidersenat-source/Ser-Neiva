<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('autor')->latest()->paginate(20);
        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'titulo'      => 'required|string|max:255',
            'extracto'    => 'nullable|string|max:400',
            'contenido'   => 'required|string',
            'imagen'      => 'nullable|image|mimes:jpeg,jpg,png,webp|max:3072',
            'youtube_url' => 'nullable|url|max:500',
            'publicado'   => 'nullable|boolean',
        ]);

        $data['user_id']  = Auth::id();
        $data['slug']     = $this->generateUniqueSlug($data['titulo']);
        $data['publicado'] = $request->boolean('publicado');

        if ($data['publicado'] && !isset($data['published_at'])) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('blogs', 'public');
        }

        Blog::create($data);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Entrada del blog creada correctamente.');
    }

    public function show(Blog $blog)
    {
        $blog->load('autor');
        return view('admin.blogs.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'titulo'      => 'required|string|max:255',
            'extracto'    => 'nullable|string|max:400',
            'contenido'   => 'required|string',
            'imagen'      => 'nullable|image|mimes:jpeg,jpg,png,webp|max:3072',
            'youtube_url' => 'nullable|url|max:500',
            'publicado'   => 'nullable|boolean',
        ]);

        $data['publicado'] = $request->boolean('publicado');

        // Si se publica por primera vez, registrar fecha
        if ($data['publicado'] && !$blog->published_at) {
            $data['published_at'] = now();
        }

        // Si se despublica, limpiar fecha
        if (!$data['publicado']) {
            $data['published_at'] = null;
        }

        // Actualizar slug si cambió el título
        if ($data['titulo'] !== $blog->titulo) {
            $data['slug'] = $this->generateUniqueSlug($data['titulo'], $blog->id);
        }

        if ($request->hasFile('imagen')) {
            if ($blog->imagen) {
                Storage::disk('public')->delete($blog->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('blogs', 'public');
        }

        $blog->update($data);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Entrada del blog actualizada correctamente.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->imagen) {
            Storage::disk('public')->delete($blog->imagen);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Entrada eliminada correctamente.');
    }

    private function generateUniqueSlug(string $titulo, ?int $ignoreId = null): string
    {
        $base = Str::slug($titulo);
        $slug = $base;
        $i    = 1;

        while (Blog::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
