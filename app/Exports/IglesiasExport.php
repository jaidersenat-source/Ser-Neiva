<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class IglesiasExport implements FromArray, WithTitle, WithColumnWidths, WithProperties, WithEvents
{
    private const LAST_COL   = 'AO';
    private const TOTAL_COLS = 41; // A → AO

    public function __construct(private readonly Collection $iglesias) {}

    // ?????? Filas completas del Excel ?????????????????????????????????????????????????????????????????????????????????????????????
    public function array(): array
    {
        $rows = [];

        // Fila 1: T??tulo
        $rows[] = $this->pad(['????  EXPORTACI??N DE IGLESIAS  |  Sistema de Gesti??n del Sector Religioso de Neiva']);

        // Fila 2: Leyenda
        $rows[] = $this->pad(['  🔖 Campo OBLIGATORIO    ◻ Campo opcional    |    Fechas: YYYY-MM-DD    |    Estado: Active / Inactive / Suspended']);

        // Fila 3: Cabeceras de sección (solo la primera celda de cada grupo)
        $sec = array_fill(0, self::TOTAL_COLS, '');
        $sec[0]  = 'INFORMACIÓN GENERAL';
        $sec[7]  = 'UBICACIÓN';
        $sec[15] = 'CONTACTO';
        $sec[20] = 'PASTOR PRINCIPAL';
        $sec[27] = 'LÍDER DE MUJERES';
        $sec[30] = 'DATOS JURÍDICOS';
        $sec[38] = 'PROGRAMAS';
        $rows[] = $sec;

        // Fila 4: Claves de campo (nombre técnico de BD)
        $rows[] = [
            'official_name','denomination','confessional_character','church_status',
            'specific_location','foundation_date','approx_members',
            'address','neighborhood','municipality','city','department','country',
            'latitud','longitud',
            'phone_landline','phone_mobile','website_or_social','email','correo_institucional',
            'pastor_full_name','pastor_document_type','pastor_document_number',
            'pastor_birth_date','leadership_period_type','pastor_phone','pastor_email',
            'women_leader_full_name','women_leader_phone','women_leader_email',
            'legal_registration_type','legal_registration_number','legal_entity_granting',
            'resolution_number','resolution_date','file_number','legal_personality_type',
            'legal_notes',
            'ministries','additional_notes','photo',
        ];

        // Fila 5: Etiquetas legibles
        $rows[] = [
            '🔖 Nombre Oficial','Denominación','Carácter Confesional','Estado',
            'Ubicación Específica','Fecha Fundación','Aprox. Miembros',
            'Dirección','Barrio','Municipio','Ciudad','Departamento','País',
            'Latitud','Longitud',
            'Teléfono Fijo','Celular Institucional','Web / Red Social','Correo General','Correo Institucional',
            'Pastor - Nombre Completo','Pastor - Tipo Doc.','Pastor - N. Documento',
            'Pastor - Fecha Nacimiento','Pastor - Tipo Período','Pastor - Teléfono','Pastor - Email',
            'Líder Mujeres - Nombre','Líder Mujeres - Teléfono','Líder Mujeres - Email',
            'Tipo Registro Legal','N° Personería Jurídica','Entidad que otorga',
            'N° Resolución','Fecha Resolución','N° Expediente','Tipo Personería',
            'Notas Jurídicas',
            'Ministerios (JSON)','Notas Adicionales','Foto (ruta/URL)',
        ];

        // Fila 6: Descripciones / hints
        $rows[] = [
            'Nombre legal completo','Ej: Cristiano, Católico, Pentecostal',
            'Ej: Evangélico, Cristiano, Católico','Active / Inactive / Suspended',
            'Ej: Comuna 5, Corregimiento El Caguan','Formato: YYYY-MM-DD','Número entero',
            'Dirección completa','','','','','',
            'Decimal, ej: 2.9273','Decimal, ej: -75.2819',
            'Sin espacios ni guiones','','','','',
            '','CC / CE / PA','Solo números',
            'Formato: YYYY-MM-DD','Determinado / Vitalicio / Indefinido','','',
            '','','',
            '','','',
            '','Formato: YYYY-MM-DD','','Especial / Extendida',
            'Observaciones legales',
            'Array JSON: ["Min1","Min2"]','','Ruta o URL de la imagen',
        ];

        // Filas de datos (fila 7 en adelante)
        foreach ($this->iglesias as $iglesia) {
            $rows[] = [
                $iglesia->official_name,
                $iglesia->denomination,
                $iglesia->confessional_character,
                $iglesia->church_status,
                $iglesia->specific_location,
                $iglesia->foundation_date?->format('Y-m-d'),
                $iglesia->approx_members,
                $iglesia->address,
                $iglesia->neighborhood,
                $iglesia->municipality,
                $iglesia->city,
                $iglesia->department,
                $iglesia->country,
                $iglesia->latitud,
                $iglesia->longitud,
                $iglesia->phone_landline,
                $iglesia->phone_mobile,
                $iglesia->website_or_social,
                $iglesia->email,
                $iglesia->correo_institucional,
                $iglesia->pastor_full_name,
                $iglesia->pastor_document_type,
                $iglesia->pastor_document_number,
                $iglesia->pastor_birth_date?->format('Y-m-d'),
                $iglesia->leadership_period_type,
                $iglesia->pastor_phone,
                $iglesia->pastor_email,
                $iglesia->women_leader_full_name,
                $iglesia->women_leader_phone,
                $iglesia->women_leader_email,
                $iglesia->legal_registration_type,
                $iglesia->legal_registration_number,
                $iglesia->legal_entity_granting,
                $iglesia->resolution_number,
                $iglesia->resolution_date?->format('Y-m-d'),
                $iglesia->file_number,
                $iglesia->legal_personality_type,
                $iglesia->legal_notes,
                $iglesia->ministries ? json_encode($iglesia->ministries, JSON_UNESCAPED_UNICODE) : null,
                $iglesia->additional_notes,
                $iglesia->photo,
            ];
        }

        return $rows;
    }

    private function pad(array $data): array
    {
        return array_pad($data, self::TOTAL_COLS, '');
    }

    // ?????? Anchos de columna ?????????????????????????????????????????????????????????????????????????????????????????????????????????????????????
    public function columnWidths(): array
    {
        return [
            'A' => 30,'B' => 16,'C' => 18,'D' => 14,'E' => 24,
            'F' => 14,'G' => 12,
            'H' => 28,'I' => 16,'J' => 14,'K' => 14,'L' => 14,
            'M' => 12,'N' => 12,'O' => 12,
            'P' => 14,'Q' => 16,'R' => 22,'S' => 24,'T' => 24,
            'U' => 26,'V' => 14,'W' => 16,'X' => 16,
            'Y' => 18,'Z' => 14,'AA'=> 24,
            'AB'=> 26,'AC'=> 16,'AD'=> 24,
            'AE'=> 22,'AF'=> 20,'AG'=> 26,'AH'=> 16,'AI'=> 16,
            'AJ'=> 16,'AK'=> 16,'AL'=> 28,
            'AM'=> 30,'AN'=> 30,'AO'=> 24,
        ];
    }

    public function title(): string { return 'Plantilla'; }

    public function properties(): array
    {
        return [
            'creator'     => 'SIRN',
            'title'       => 'Exportaci??n de Iglesias ??? SIRN',
            'description' => 'Generado autom??ticamente ?? Compatible con importaci??n',
            'company'     => 'Alcald??a de Neiva',
        ];
    }

    // ?????? Estilos via AfterSheet ??????????????????????????????????????????????????????????????????????????????????????????????????????
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lc    = self::LAST_COL;
                $n     = $this->iglesias->count();
                $last  = 6 + $n;

                // ?????? Merge: fila 1 y 2 ??????????????????????????????????????????????????????????????????????????????????????????
                $sheet->mergeCells("A1:{$lc}1");
                $sheet->mergeCells("A2:{$lc}2");

                // ?????? Merge: secciones fila 3 ????????????????????????????????????????????????????????????????????????
                $sheet->mergeCells('A3:G3');
                $sheet->mergeCells('H3:O3');
                $sheet->mergeCells('P3:T3');
                $sheet->mergeCells('U3:AA3');
                $sheet->mergeCells('AB3:AD3');
                $sheet->mergeCells('AE3:AL3');
                $sheet->mergeCells('AM3:AO3');

                // ?????? Fila 1: T??tulo ???????????????????????????????????????????????????????????????????????????????????????????????????
                $sheet->getStyle("A1:{$lc}1")->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 13, 'color' => ['rgb' => 'FFFFFF']],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E3A8A']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheet->getRowDimension(1)->setRowHeight(30);

                // ?????? Fila 2: Leyenda ????????????????????????????????????????????????????????????????????????????????????????????????
                $sheet->getStyle("A2:{$lc}2")->applyFromArray([
                    'font'      => ['size' => 8.5, 'color' => ['rgb' => '7C5C00']],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFF9E6']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                ]);
                $sheet->getRowDimension(2)->setRowHeight(16);

                // ?????? Fila 3: Colores por secci??n ????????????????????????????????????????????????????????????
                foreach ([
                    'A3:G3'   => '4472C4',
                    'H3:O3'   => '2E75B6',
                    'P3:T3'   => '548235',
                    'U3:AA3'  => '833C00',
                    'AB3:AD3' => '7030A0',
                    'AE3:AL3' => 'C55A11',
                    'AM3:AO3' => '7F6000',
                ] as $range => $bg) {
                    $sheet->getStyle($range)->applyFromArray([
                        'font'      => ['bold' => true, 'size' => 9, 'color' => ['rgb' => 'FFFFFF']],
                        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bg]],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                        'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'FFFFFF']]],
                    ]);
                }
                $sheet->getRowDimension(3)->setRowHeight(18);

                // ?????? Fila 4: Claves de campo ????????????????????????????????????????????????????????????????????????
                $sheet->getStyle("A4:{$lc}4")->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 8, 'color' => ['rgb' => 'FFFFFF']],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1E3A8A']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '2D4FA0']]],
                ]);
                $sheet->getRowDimension(4)->setRowHeight(16);

                // ?????? Fila 5: Etiquetas (fondo claro por secci??n) ????????????
                foreach ([
                    'A5:G5'   => 'D6E4F7',
                    'H5:O5'   => 'D6EAF8',
                    'P5:T5'   => 'D5E8D4',
                    'U5:AA5'  => 'F8D7C0',
                    'AB5:AD5' => 'E8D5F5',
                    'AE5:AL5' => 'FCE5D4',
                    'AM5:AO5' => 'FFF2CC',
                ] as $range => $bg) {
                    $sheet->getStyle($range)->applyFromArray([
                        'font'      => ['bold' => true, 'size' => 8, 'color' => ['rgb' => '1E293B']],
                        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bg]],
                        'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                        'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E2E8F0']]],
                    ]);
                }
                $sheet->getRowDimension(5)->setRowHeight(18);

                // ?????? Fila 6: Hints (it??lica gris) ?????????????????????????????????????????????????????????
                $sheet->getStyle("A6:{$lc}6")->applyFromArray([
                    'font'      => ['italic' => true, 'size' => 7.5, 'color' => ['rgb' => '64748B']],
                    'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F8FAFC']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
                    'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E2E8F0']]],
                ]);
                $sheet->getRowDimension(6)->setRowHeight(14);

                // ?????? Filas de datos ???????????????????????????????????????????????????????????????????????????????????????????????????
                for ($i = 0; $i < $n; $i++) {
                    $row = $i + 7;
                    $bg  = ($i % 2 === 0) ? 'FFFFFF' : 'F8FAFC';
                    $sheet->getStyle("A{$row}:{$lc}{$row}")->applyFromArray([
                        'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bg]],
                        'font'      => ['size' => 8.5],
                        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                        'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E2E8F0']]],
                    ]);
                    $sheet->getRowDimension($row)->setRowHeight(15);
                }

                // ?????? Congelar desde fila 7 ??????????????????????????????????????????????????????????????????????????????
                $sheet->freezePane('A7');

                // ?????? Auto-filtro en fila 4 ??????????????????????????????????????????????????????????????????????????????
                $sheet->setAutoFilter("A4:{$lc}4");

                // ?????? Borde exterior de toda la tabla ?????????????????????????????????????????????
                if ($last >= 1) {
                    $sheet->getStyle("A1:{$lc}{$last}")->applyFromArray([
                        'borders' => ['outline' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['rgb' => '1E3A8A']]],
                    ]);
                }
            },
        ];
    }
}