<?php

namespace App\Http\Controllers;

use App\Models\Blog;

class BlogPublicoController extends Controller
{
    public function index()
    {
        $blogs = Blog::with('autor')
            ->publicados()
            ->orderByDesc('published_at')
            ->paginate(9);

        return view('blog.index', compact('blogs'));
    }

    public function show(string $slug)
    {
        $blog = Blog::with('autor')
            ->publicados()
            ->where('slug', $slug)
            ->firstOrFail();

        // Posts relacionados (excluyendo el actual)
        $relacionados = Blog::publicados()
            ->where('id', '!=', $blog->id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get();

        return view('blog.show', compact('blog', 'relacionados'));
    }
}
