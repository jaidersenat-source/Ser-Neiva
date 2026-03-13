<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FoundationRequest;
use App\Models\Foundation;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FoundationController extends Controller
{
    public function index(): View
    {
        $foundations = Foundation::latest()->paginate(15);

        return view('admin.foundations.index', [
            'foundations' => $foundations,
            'total'       => Foundation::count(),
        ]);
    }

    public function create(): View
    {
        return view('admin.foundations.create', [
            'foundation' => new Foundation(),
        ]);
    }

    public function store(FoundationRequest $request): RedirectResponse
    {
        $foundation = Foundation::create($request->validated());

        return redirect()
            ->route('admin.foundations.index')
            ->with('success', "Fundación «{$foundation->name}» registrada correctamente.");
    }

    public function edit(Foundation $foundation): View
    {
        return view('admin.foundations.edit', compact('foundation'));
    }

    public function update(FoundationRequest $request, Foundation $foundation): RedirectResponse
    {
        $foundation->update($request->validated());

        return redirect()
            ->route('admin.foundations.index')
            ->with('success', "Fundación «{$foundation->name}» actualizada correctamente.");
    }

    public function destroy(Foundation $foundation): RedirectResponse
    {
        $nombre = $foundation->name;
        $foundation->delete();

        return redirect()
            ->route('admin.foundations.index')
            ->with('success', "Fundación «{$nombre}» eliminada correctamente.");
    }
}
