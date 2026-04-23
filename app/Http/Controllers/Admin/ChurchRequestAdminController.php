<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ChurchRequestStatusMail;
use App\Models\ChurchRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ChurchRequestAdminController extends Controller
{
    public function index(Request $request)
    {
        $estado = $request->query('estado');

        $requests = ChurchRequest::query()
            ->when($estado, fn($q) => $q->where('estado', $estado))
            ->orderByRaw("FIELD(estado,'pendiente','revisada','aprobada','rechazada')")
            ->orderByDesc('created_at')
            ->paginate(20)
            ->withQueryString();

        $counts = [
            'total'     => ChurchRequest::count(),
            'pendiente' => ChurchRequest::where('estado', 'pendiente')->count(),
            'revisada'  => ChurchRequest::where('estado', 'revisada')->count(),
            'aprobada'  => ChurchRequest::where('estado', 'aprobada')->count(),
            'rechazada' => ChurchRequest::where('estado', 'rechazada')->count(),
        ];

        return view('admin.church_requests.index', compact('requests', 'counts', 'estado'));
    }

    public function show(ChurchRequest $churchRequest)
    {
        return view('admin.church_requests.show', ['req' => $churchRequest]);
    }

    public function update(Request $request, ChurchRequest $churchRequest)
    {
        $nuevoEstado = $request->input('estado');

        $rules = [
            'estado'          => ['required', 'in:pendiente,revisada,aprobada,rechazada'],
            'notas_admin'     => ['nullable', 'string', 'max:2000'],
            'motivo_rechazo'  => ['nullable', 'string', 'max:2000'],
        ];

        // Si el nuevo estado es rechazada, el motivo es obligatorio
        if ($nuevoEstado === 'rechazada') {
            $rules['motivo_rechazo'] = ['required', 'string', 'min:10', 'max:2000'];
        }

        $data = $request->validate($rules, [
            'motivo_rechazo.required' => 'Debes indicar el motivo del rechazo.',
            'motivo_rechazo.min'      => 'El motivo debe tener al menos 10 caracteres.',
        ]);

        $estadoAnterior = $churchRequest->estado;
        $churchRequest->update($data);

        // Enviar correo al solicitante solo cuando cambia el estado
        // y es uno de los estados que requieren notificación
        $estadosNotificables = ['revisada', 'aprobada', 'rechazada'];

        if ($nuevoEstado !== $estadoAnterior && in_array($nuevoEstado, $estadosNotificables)) {
            try {
                Mail::to($churchRequest->email)
                    ->send(new ChurchRequestStatusMail($churchRequest, $nuevoEstado));
            } catch (\Throwable $e) {
                Log::error('ChurchRequestStatusMail failed: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Solicitud actualizada y notificación enviada.');
    }

    public function destroy(ChurchRequest $churchRequest)
    {
        $churchRequest->delete();
        return redirect()->route('admin.church-requests.index')
            ->with('success', 'Solicitud eliminada.');
    }
}
