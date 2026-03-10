<?php

namespace App\Http\Controllers\Admin;

use App\Exports\IglesiasExport;
use App\Http\Controllers\Controller;
use App\Models\Iglesia;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ExportController extends Controller
{
    /**
     * Construye la query base con filtros opcionales.
     * Principio SRP: lógica de filtrado centralizada aquí.
     */
    private function buildQuery(Request $request)
    {
        $query = Iglesia::with('ayudas')->latest();

        if ($request->filled('estado'))
            $query->where('estado', $request->estado);

        if ($request->filled('denominacion'))
            $query->where('denominacion', $request->denominacion);

        if ($request->filled('comuna'))
            $query->where('comuna', $request->comuna);

        if ($request->filled('ayuda_id'))
            $query->whereHas('ayudas', fn($q) => $q->where('ayudas.id', $request->integer('ayuda_id')));

        return $query;
    }

    /**
     * GET /admin/iglesias/export/pdf
     * Descarga el reporte en PDF con diseño institucional.
     */
    public function pdf(Request $request): Response
    {
        $iglesias = $this->buildQuery($request)->get();

        $pdf = Pdf::loadView('admin.exports.iglesias-pdf', [
            'iglesias'  => $iglesias,
            'total'     => $iglesias->count(),
            'activas'   => $iglesias->where('estado', 'activo')->count(),
            'inactivas' => $iglesias->where('estado', 'inactivo')->count(),
            'filtros'   => $this->describeFiltros($request),
            'fecha'     => now()->translatedFormat('d \d\e F \d\e Y'),
            'hora'      => now()->format('H:i'),
        ])
        ->setPaper('a4', 'landscape')
        ->setOption([
            'defaultFont'          => 'sans-serif',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled'      => true,
            'dpi'                  => 150,
        ]);

        return $pdf->download('SIRN_Iglesias_' . now()->format('Ymd_His') . '.pdf');
    }

    /**
     * GET /admin/iglesias/export/excel
     * Descarga el reporte en formato .xlsx
     */
    public function excel(Request $request): BinaryFileResponse
    {
        $iglesias = $this->buildQuery($request)->get();

        return Excel::download(
            new IglesiasExport($iglesias),
            'SIRN_Iglesias_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    /**
     * Genera descripción legible de los filtros activos.
     */
    private function describeFiltros(Request $request): string
    {
        $partes = [];
        if ($request->filled('estado'))       $partes[] = 'Estado: '       . ucfirst($request->estado);
        if ($request->filled('denominacion')) $partes[] = 'Denominación: ' . $request->denominacion;
        if ($request->filled('comuna'))       $partes[] = 'Comuna: '       . $request->comuna;
        return empty($partes) ? 'Sin filtros aplicados' : implode(' | ', $partes);
    }
}