<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class IglesiasExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    WithColumnWidths,
    WithProperties,
    WithEvents,
    ShouldAutoSize
{
    public function __construct(private readonly Collection $iglesias) {}

    // ── Datos ──────────────────────────────────────────────────
    public function collection(): Collection
    {
        return $this->iglesias;
    }

    // ── Encabezados ────────────────────────────────────────────
    public function headings(): array
    {
        return [
            '#', 'Nombre', 'Denominación', 'Dirección', 'Comuna',
            'Corregimiento', 'Pastor / Sacerdote', 'Fecha Nacimiento Líder', 'Teléfono',
            'Correo', 'Celular Institucional', 'Correo Institucional', 'Entidad Registrada',
            'Promedio Asistentes', 'Descripción', 'Latitud', 'Longitud', 'Estado',
            'Ayudas Sociales', 'Fecha Registro',
        ];
    }

    // ── Mapeo de cada fila ────────────────────────────────────
    public function map($iglesia): array
    {
        return [
            $iglesia->id,
            $iglesia->nombre,
            $iglesia->denominacion,
            $iglesia->direccion,
            $iglesia->comuna          ?? '—',
            $iglesia->corregimiento   ?? '—',
            $iglesia->pastor_sacerdote ?? '—',
            $iglesia->fecha_nacimiento_lider ? \Carbon\Carbon::parse($iglesia->fecha_nacimiento_lider)->format('d/m/Y') : '—',
            $iglesia->telefono        ?? '—',
            $iglesia->email           ?? '—',
            $iglesia->celular_institucional ?? '—',
            $iglesia->correo_institucional ?? '—',
            $iglesia->entidad_registrada_colombia ?? '—',
            $iglesia->promedio_asistentes ?? '—',
            $iglesia->descripcion ?? '—',
            $iglesia->latitud,
            $iglesia->longitud,
            ucfirst($iglesia->estado),
            $iglesia->ayudas->pluck('nombre')->implode(', ') ?: 'Ninguna',
            $iglesia->created_at->format('d/m/Y'),
        ];
    }

    // ── Estilos base (filas de título + encabezados) ──────────
    public function styles(Worksheet $sheet): array
    {
        // Solo estilos para la fila de encabezados (fila 1)
        return [
            1 => [
                'font'      => ['bold' => true, 'size' => 9, 'color' => ['rgb' => 'FFFFFF']],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E3A8A']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            ],
        ];
    }

    // ── Anchos de columna ──────────────────────────────────────
    public function columnWidths(): array
    {
        return [
            'A' =>  5,   // #
            'B' => 30,   // Nombre
            'C' => 20,   // Denominación
            'D' => 32,   // Dirección
            'E' => 14,   // Comuna
            'F' => 18,   // Corregimiento
            'G' => 24,   // Pastor
            'H' => 16,   // Fecha Nacimiento
            'I' => 14,   // Teléfono
            'J' => 26,   // Correo
            'K' => 16,   // Celular Institucional
            'L' => 26,   // Correo Institucional
            'M' => 16,   // Entidad Registrada
            'N' => 16,   // Promedio Asistentes
            'O' => 32,   // Descripción
            'P' => 12,   // Latitud
            'Q' => 12,   // Longitud
            'R' => 11,   // Estado
            'S' => 38,   // Ayudas
            'T' => 14,   // Fecha
        ];
    }

    // ── Nombre de la hoja ──────────────────────────────────────
    public function title(): string { return 'Iglesias'; }

    // ── Propiedades del documento ──────────────────────────────
    public function properties(): array
    {
        return [
            'creator'     => 'SIRN',
            'title'       => 'Reporte de Iglesias – SIRN',
            'description' => 'Reporte generado automáticamente',
            'company'     => 'Alcaldía de Neiva',
        ];
    }

    // ── Eventos: filas alternadas + colores estado ─────────────
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $count = $this->iglesias->count();

                // Altura filas de encabezado y datos
                for ($i = 0; $i < $count; $i++) {
                    $row   = $i + 2;
                    $color = ($i % 2 === 0) ? 'FFFFFF' : 'F8FAFC';
                    $sheet->getStyle("A{$row}:T{$row}")->applyFromArray([
                        'fill'    => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $color]],
                        'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E2E8F0']]],
                        'font'    => ['size' => 8.5],
                        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                    ]);
                    $sheet->getRowDimension($row)->setRowHeight(15);
                }

                // Centrar columnas numéricas y de fecha
                $sheet->getStyle("A2:A" . ($count+1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("P2:Q" . ($count+1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
                $sheet->getStyle("T2:T" . ($count+1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Congelar primera fila de datos
                $sheet->freezePane('A2');

                // Auto-filtro en encabezados
                $sheet->setAutoFilter("A1:T1");

                // Borde exterior de toda la tabla
                if ($count > 0) {
                    $sheet->getStyle("A1:T" . ($count+1))->applyFromArray([
                        'borders' => [
                            'outline' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['rgb' => '1E3A8A']],
                        ],
                    ]);
                }
            },
        ];
    }
}