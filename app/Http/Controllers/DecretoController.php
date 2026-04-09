<?php

namespace App\Http\Controllers;

use App\Models\Decreto;
use Illuminate\Support\Facades\Storage;

class DecretoController extends Controller
{
    public function index()
    {
        $decretos = Decreto::orderByDesc('published_at')->paginate(12);
        return view('normatividad.index', compact('decretos'));
    }

    public function show($slug)
    {
        $decreto = Decreto::where('slug', $slug)->firstOrFail();
        return view('normatividad.show', compact('decreto'));
    }

    public function streamInline($id)
    {
        $decreto = Decreto::findOrFail($id);

        if (!$decreto->filename) abort(404);

        $path = Storage::disk('public')->path('normatividad/' . $decreto->filename);
        if (!file_exists($path)) abort(404);

        return response()->file($path, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $decreto->filename . '"',
        ]);
    }

    public function download($id)
    {
        $decreto = Decreto::findOrFail($id);

        if (!$decreto->filename) abort(404);

        $path = 'normatividad/' . $decreto->filename;
        if (!Storage::disk('public')->exists($path)) abort(404);

        return Storage::disk('public')->download($path, $decreto->filename);
    }
}