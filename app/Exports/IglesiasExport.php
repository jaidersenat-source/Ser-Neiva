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
    private const LAST_COL   = 'AW';
    private const TOTAL_COLS = 49; // A ??? AW

    public function __construct(private readonly Collection $iglesias) {}

    // ?????? Filas completas del Excel ?????????????????????????????????????????????????????????????????????????????????????????????
    public function array(): array
    {
        $rows = [];

        // Fila 1: T??tulo
        $rows[] = $this->pad(['????  EXPORTACI??N DE IGLESIAS  |  Sistema de Gesti??n del Sector Religioso de Neiva']);

        // Fila 2: Leyenda
        $rows[] = $this->pad(['  ???? Campo OBLIGATORIO    ??? Campo opcional    |    Fechas: YYYY-MM-DD    |    Estado BD: activo / inactivo    |    Registrada Colombia: SI / NO / EN_PROCESO']);

        // Fila 3: Cabeceras de secci??n (solo la primera celda de cada grupo)
        $sec = array_fill(0, self::TOTAL_COLS, '');
        $sec[0]  = 'INFORMACI??N GENERAL';
        $sec[9]  = 'UBICACI??N';
        $sec[19] = 'CONTACTO';
        $sec[25] = 'PASTOR PRINCIPAL';
        $sec[33] = 'L??DER DE MUJERES';
        $sec[36] = 'DATOS JUR??DICOS';
        $sec[45] = 'PROGRAMAS';
        $rows[] = $sec;

        // Fila 4: Claves de campo (nombre t??cnico de BD)
        $rows[] = [
            'nombre','official_name','denomination','confessional_character','church_status',
            'estado','specific_location','foundation_date','approx_members',
            'address','direccion','neighborhood','municipality','city','department','country',
            'corregimiento','latitud','longitud',
            'phone_landline','phone_mobile','celular_institucional','website_or_social',
            'correo_institucional','email',
            'pastor_full_name','pastor_sacerdote','pastor_document_type','pastor_document_number',
            'pastor_birth_date','leadership_period_type','pastor_phone','pastor_email',
            'women_leader_full_name','women_leader_phone','women_leader_email',
            'legal_registration_type','legal_registration_number','legal_entity_granting',
            'resolution_number','resolution_date','file_number','legal_personality_type',
            'legal_notes','entidad_registrada_colombia',
            'ministries','additional_notes','descripcion','photo',
        ];

        // Fila 5: Etiquetas legibles
        $rows[] = [
            '???? Nombre (legacy)','???? Nombre Oficial','Denominaci??n','Car??cter Confesional','Estado (texto)',
            '???? Estado BD','Ubicaci??n Espec??fica','Fecha Fundaci??n','Aprox. Miembros',
            'Direcci??n','Direcci??n (legacy)','Barrio','Municipio','Ciudad','Departamento','Pa??s',
            'Corregimiento','Latitud','Longitud',
            'Tel??fono Fijo','Celular Institucional','Celular (legacy)','Web / Red Social',
            'Correo Institucional','Email (legacy)',
            'Pastor - Nombre Completo','Pastor (legacy)','Pastor - Tipo Doc.','Pastor - N. Documento',
            'Pastor - Fecha Nacimiento','Pastor - Tipo Per??odo','Pastor - Tel??fono','Pastor - Email',
            'L??der Mujeres - Nombre','L??der Mujeres - Tel??fono','L??der Mujeres - Email',
            'Tipo Registro Legal','N?? Personer??a Jur??dica','Entidad que otorga',
            'N?? Resoluci??n','Fecha Resoluci??n','N?? Expediente','Tipo Personer??a',
            'Notas Jur??dicas','Registrada Colombia',
            'Ministerios (JSON)','Notas Adicionales','Descripci??n (legacy)','Foto (ruta/URL)',
        ];

        // Fila 6: Descripciones / hints
        $rows[] = [
            'Nombre corto o legado','Nombre legal completo','Ej: Cristiano, Cat??lico, Pentecostal',
            'Ej: Evang??lico, Cristiano, Cat??lico','Texto libre del estado','Solo: activo / inactivo',
            'Ej: Comuna 5, Corregimiento El Caguan','Formato: YYYY-MM-DD','N??mero entero',
            '','Igual que address','','','','','',
            'Solo si aplica zona rural','Decimal, ej: 2.9273','Decimal, ej: -75.2819',
            'Sin espacios ni guiones','','Igual que phone_mobile','',
            '','Igual que correo_institucional',
            '','','CC / CE / PA','Solo n??meros',
            'Formato: YYYY-MM-DD','Determinado / Vitalicio / Indefinido','','',
            '','','',
            '','','',
            '','Formato: YYYY-MM-DD','','Especial / Extendida',
            'Observaciones legales','SI / NO / EN_PROCESO',
            'Array JSON: ["Min1","Min2"]','','Descripci??n general','Ruta o URL de la imagen',
        ];

        // Filas de datos (fila 7 en adelante)
        foreach ($this->iglesias as $iglesia) {
            $rows[] = [
                $iglesia->nombre,
                $iglesia->official_name,
                $iglesia->denomination,
                $iglesia->confessional_character,
                $iglesia->church_status,
                $iglesia->estado,
                $iglesia->specific_location,
                $iglesia->foundation_date?->format('Y-m-d'),
                $iglesia->approx_members ?? $iglesia->promedio_asistentes,
                $iglesia->address,
                $iglesia->direccion,
                $iglesia->neighborhood,
                $iglesia->municipality,
                $iglesia->city,
                $iglesia->department,
                $iglesia->country,
                $iglesia->corregimiento,
                $iglesia->latitud,
                $iglesia->longitud,
                $iglesia->phone_landline,
                $iglesia->phone_mobile ?? $iglesia->celular_institucional,
                $iglesia->celular_institucional,
                $iglesia->website_or_social,
                $iglesia->correo_institucional,
                $iglesia->email,
                $iglesia->pastor_full_name,
                $iglesia->pastor_sacerdote,
                $iglesia->pastor_document_type,
                $iglesia->pastor_document_number,
                ($iglesia->pastor_birth_date ?? $iglesia->fecha_nacimiento_lider)?->format('Y-m-d'),
                $iglesia->leadership_period_type,
                $iglesia->pastor_phone ?? $iglesia->telefono,
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
                $iglesia->entidad_registrada_colombia,
                $iglesia->ministries ? json_encode($iglesia->ministries, JSON_UNESCAPED_UNICODE) : null,
                $iglesia->additional_notes,
                $iglesia->descripcion,
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
            'A' => 22,'B' => 30,'C' => 16,'D' => 18,'E' => 14,
            'F' => 11,'G' => 24,'H' => 14,'I' => 12,
            'J' => 28,'K' => 28,'L' => 16,'M' => 14,'N' => 14,
            'O' => 14,'P' => 12,'Q' => 18,'R' => 12,'S' => 12,
            'T' => 14,'U' => 16,'V' => 16,'W' => 22,'X' => 24,'Y' => 24,
            'Z' => 26,'AA'=> 24,'AB'=> 14,'AC'=> 16,'AD'=> 16,
            'AE'=> 18,'AF'=> 14,'AG'=> 24,
            'AH'=> 26,'AI'=> 16,'AJ'=> 24,
            'AK'=> 22,'AL'=> 20,'AM'=> 26,'AN'=> 16,'AO'=> 16,
            'AP'=> 16,'AQ'=> 16,'AR'=> 28,'AS'=> 16,
            'AT'=> 30,'AU'=> 30,'AV'=> 30,'AW'=> 24,
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
                $sheet->mergeCells('A3:I3');
                $sheet->mergeCells('J3:S3');
                $sheet->mergeCells('T3:Y3');
                $sheet->mergeCells('Z3:AG3');
                $sheet->mergeCells('AH3:AJ3');
                $sheet->mergeCells('AK3:AS3');
                $sheet->mergeCells('AT3:AW3');

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
                    'A3:I3'   => '4472C4',
                    'J3:S3'   => '2E75B6',
                    'T3:Y3'   => '548235',
                    'Z3:AG3'  => '833C00',
                    'AH3:AJ3' => '7030A0',
                    'AK3:AS3' => 'C55A11',
                    'AT3:AW3' => '7F6000',
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
                    'A5:I5'   => 'D6E4F7',
                    'J5:S5'   => 'D6EAF8',
                    'T5:Y5'   => 'D5E8D4',
                    'Z5:AG5'  => 'F8D7C0',
                    'AH5:AJ5' => 'E8D5F5',
                    'AK5:AS5' => 'FCE5D4',
                    'AT5:AW5' => 'FFF2CC',
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