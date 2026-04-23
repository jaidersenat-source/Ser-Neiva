<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendCampaignJob;
use App\Models\Campaign;
use App\Models\Iglesia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse as HttpRedirectResponse;

class CampaignController extends Controller
{
    public function index(): View
    {
        $campaigns = Campaign::withCount('recipients')
            ->latest()
            ->paginate(15);

        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function create(): View
    {
        $cities = Iglesia::whereNotNull('city')
            ->where('city', '!=', '')
            ->distinct()
            ->orderBy('city')
            ->pluck('city');

        $iglesias = Iglesia::select(
                'id', 'official_name',
                'pastor_email', 'correo_institucional', 'email',
                'city', 'municipality', 'denomination'
            )
            ->where(fn($q) => $q
                ->where(fn($a) => $a->whereNotNull('pastor_email')->where('pastor_email', '!=', ''))
                ->orWhere(fn($b) => $b->whereNotNull('correo_institucional')->where('correo_institucional', '!=', ''))
                ->orWhere(fn($c) => $c->whereNotNull('email')->where('email', '!=', ''))
            )
            ->orderBy('official_name')
            ->get();

        return view('admin.campaigns.create', compact('cities', 'iglesias'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'subject'      => 'required|string|max:255',
            'message'      => 'required|string',
            'filter_type'  => 'required|in:all,city,selected',
            'city'         => 'required_if:filter_type,city|nullable|string|max:100',
            'iglesias'     => 'required_if:filter_type,selected|nullable|array',
            'iglesias.*'   => 'exists:iglesias,id',
            'images'       => 'nullable|array|max:5',
            'images.*'     => 'image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $campaign = Campaign::create([
            'subject'     => $validated['subject'],
            'message'     => $validated['message'],
            'filter_type' => $validated['filter_type'],
            'city'        => $validated['city'] ?? null,
        ]);

        // Guardar imágenes
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('campaigns/' . $campaign->id, 'public');
                $campaign->images()->create([
                    'path'          => $path,
                    'original_name' => $image->getClientOriginalName(),
                ]);
            }
        }

        // Asignar destinatarios desde iglesias
        $iglesiaIds = $this->resolveIglesias($campaign, $validated);
        foreach ($iglesiaIds as $iglesiaId) {
            $campaign->recipients()->create(['iglesia_id' => $iglesiaId]);
        }

        return redirect()
            ->route('admin.campaigns.show', $campaign)
            ->with('success', 'Campaña creada correctamente. Revisa la vista previa antes de enviar.');
    }

    public function show(Campaign $campaign): View
    {
        $campaign->load(['images', 'recipients.iglesia']);

        return view('admin.campaigns.show', compact('campaign'));
    }

    public function send(Campaign $campaign): RedirectResponse
    {
        if ($campaign->isSent()) {
            return back()->with('error', 'Esta campaña ya fue enviada.');
        }

        if ($campaign->recipients()->count() === 0) {
            return back()->with('error', 'No hay destinatarios para esta campaña.');
        }

        SendCampaignJob::dispatch($campaign);

        return redirect()
            ->route('admin.campaigns.index')
            ->with('success', 'La campaña se está enviando en segundo plano. Los correos llegarán en unos minutos.');
    }

    public function destroy(Campaign $campaign): RedirectResponse
    {
        if ($campaign->isSent()) {
            return back()->with('error', 'No se puede eliminar una campaña ya enviada.');
        }

        // Eliminar imágenes del storage
        foreach ($campaign->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $campaign->delete();

        return redirect()
            ->route('admin.campaigns.index')
            ->with('success', 'Campaña eliminada correctamente.');
    }

    /**
     * Purge sent campaigns older than X days. Accepts POST param `days` (int).
     */
    public function purgeOld(Request $request): RedirectResponse
    {
        $days = (int) $request->input('days', 90);
        if ($days <= 0) $days = 90;

        $cutoff = now()->subDays($days);
        $toDelete = Campaign::whereNotNull('sent_at')->where('sent_at', '<', $cutoff)->get();
        $count = 0;
        foreach ($toDelete as $campaign) {
            // delete images from storage
            foreach ($campaign->images as $image) {
                Storage::disk('public')->delete($image->path);
            }
            $campaign->delete();
            $count++;
        }

        return redirect()->route('admin.campaigns.index')
            ->with('success', "Se eliminaron {$count} campañas enviadas hace más de {$days} días.");
    }

    /**
     * Sube una imagen desde el editor y retorna la URL.
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
        ]);

        $path = $request->file('image')->store('campaigns/editor', 'public');

        return response()->json([
            'url' => asset('storage/' . $path),
        ]);
    }

    // ── Helpers ───────────────────────────────────────────

    private function resolveIglesias(Campaign $campaign, array $validated): array
    {
        $withEmail = fn($q) => $q
            ->where(fn($q2) => $q2
                ->where(fn($a) => $a->whereNotNull('pastor_email')->where('pastor_email', '!=', ''))
                ->orWhere(fn($b) => $b->whereNotNull('correo_institucional')->where('correo_institucional', '!=', ''))
                ->orWhere(fn($c) => $c->whereNotNull('email')->where('email', '!=', ''))
            );

        return match ($campaign->filter_type) {
            'all'      => Iglesia::where($withEmail)->pluck('id')->toArray(),
            'city'     => Iglesia::where($withEmail)
                            ->where(fn($q) => $q->where('city', $campaign->city)
                                ->orWhere('municipality', $campaign->city))
                            ->pluck('id')->toArray(),
            'selected' => $validated['iglesias'] ?? [],
        };
    }

    public static function getEmail(Iglesia $iglesia): ?string
    {
        return $iglesia->getContactEmail();
    }

    public static function getContactName(Iglesia $iglesia): string
    {
        return $iglesia->pastor_full_name
            ?: ($iglesia->official_name ?? 'Sin nombre');
    }
}
