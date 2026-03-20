<?php

namespace App\Imports;

use App\Models\Iglesia;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IglesiasImport implements ToCollection, WithHeadingRow, WithMultipleSheets
{
    public int $created = 0;
    public int $skipped = 0;
    public array $errors = [];

    private array $toCreate = [];
    private array $seen = [];

    // Solo procesar la hoja "Plantilla" (índice 0)
    public function sheets(): array
    {
        return [0 => $this];
    }

    // La fila 4 de la plantilla oficial contiene las claves de campo
    public function headingRow(): int
    {
        return 4;
    }

    public function collection(Collection $rows)
    {
        $rules = [
            // Identificadores principales
            'official_name'              => 'required|string|max:200',
            // Información general
            'denomination'               => 'nullable|string|max:50',
            'confessional_character'     => 'nullable|string|max:50',
            'church_status'              => 'required|string|max:50',
            'specific_location'          => 'nullable|string|max:255',
            'foundation_date'            => 'nullable|date',
            'approx_members'             => 'nullable|integer|min:0',
            // Ubicación
            'address'                    => 'nullable|string|max:255',
            'neighborhood'               => 'nullable|string|max:100',
            'municipality'               => 'nullable|string|max:100',
            'comuna'                     => 'nullable|string|max:100',
            'city'                       => 'nullable|string|max:100',
            'department'                 => 'nullable|string|max:100',
            'country'                    => 'nullable|string|max:80',
            'latitud'                    => 'nullable|numeric',
            'longitud'                   => 'nullable|numeric',
            // Contacto
            'email'                      => 'nullable|email|max:150',
            'phone_landline'             => 'nullable|string|max:20',
            'phone_mobile'               => 'nullable|string|max:20',
            'website_or_social'          => 'nullable|string|max:255',
            // Pastor principal
            'pastor_full_name'           => 'nullable|string|max:150',
            'pastor_document_type'       => 'nullable|string|max:20',
            'pastor_document_number'     => 'nullable|string|max:30',
            'pastor_birth_date'          => 'nullable|date',
            'leadership_period_type'     => 'nullable|string|max:30',
            'pastor_phone'               => 'nullable|string|max:20',
            'pastor_email'               => 'nullable|email|max:150',
            // Líder de mujeres
            'women_leader_full_name'     => 'nullable|string|max:150',
            'women_leader_phone'         => 'nullable|string|max:20',
            'women_leader_email'         => 'nullable|email|max:150',
            // Datos jurídicos
            'legal_registration_type'    => 'nullable|string|max:80',
            'legal_registration_number'  => 'nullable|string|max:50',
            'legal_entity_granting'      => 'nullable|string|max:200',
            'resolution_number'          => 'nullable|string|max:80',
            'resolution_date'            => 'nullable|date',
            'file_number'                => 'nullable|string|max:80',
            'legal_personality_type'     => 'nullable|string|max:30',
            'legal_notes'                => 'nullable|string|max:2000',
            // Programas y notas
            'ministries'                 => 'nullable|string',
            'additional_notes'           => 'nullable|string|max:2000',
            'photo'                      => 'nullable|string|max:500',
        ];

        // Con headingRow=4, la colección empieza en fila 5.
        // Saltamos los 2 primeros elementos (filas 5 y 6 = etiquetas y descripciones).
        $dataRows = $rows->skip(2)->values(); // values() reinicia los índices desde 0

        foreach ($dataRows as $index => $row) {
            $rowNumber = $index + 7; // índice 0 = fila 7 de Excel

            $data = array_change_key_case($row->toArray(), CASE_LOWER);

            // Omitir filas completamente vacías
            $hasContent = collect($data)->filter(fn($v) => $v !== null && $v !== '')->isNotEmpty();
            if (!$hasContent) {
                continue;
            }

            // === NORMALIZACIÓN ANTES DE VALIDAR ===

            // pastor_document_type: "CC - Cédula de Ciudadanía" → "CC"
            if (!empty($data['pastor_document_type'])) {
                $dt = strtoupper(trim((string)$data['pastor_document_type']));
                if (str_starts_with($dt, 'CC'))  $data['pastor_document_type'] = 'CC';
                elseif (str_starts_with($dt, 'CE')) $data['pastor_document_type'] = 'CE';
                elseif (str_starts_with($dt, 'PA')) $data['pastor_document_type'] = 'PA';
                else $data['pastor_document_type'] = substr($dt, 0, 20);
            }

            // church_status: normalizar a Title Case
            if (!empty($data['church_status'])) {
                $cs = strtolower(trim((string)$data['church_status']));
                // Mapear variantes comunes
                $data['church_status'] = match($cs) {
                    'activo', 'active', 'activa' => 'Active',
                    'inactivo', 'inactive', 'inactiva' => 'Inactive',
                    'suspended', 'suspendido', 'suspendida' => 'Suspended',
                    default => ucfirst($cs),
                };
            }

            // leadership_period_type: normalizar a Title Case para coincidir con BD
            if (!empty($data['leadership_period_type'])) {
                $lpt = strtolower(trim((string)$data['leadership_period_type']));
                $data['leadership_period_type'] = ucfirst($lpt);
            }

            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                $this->errors[] = [
                    'row'       => $rowNumber,
                    'nombre'    => $data['official_name'] ?? 'N/A',
                    'direccion' => $data['address'] ?? 'N/A',
                    'errors'    => $validator->errors()->all(),
                ];
                continue;
            }

            $validated = $validator->validated();

            // Detección de duplicados por official_name
            $keyNorm = trim(strtolower($validated['official_name']));

            if (isset($this->seen[$keyNorm]) ||
                Iglesia::whereRaw('LOWER(official_name) = ?', [$keyNorm])->exists()) {
                $this->skipped++;
                continue;
            }

            // Parsear ministries como JSON si viene como string
            if (!empty($validated['ministries'])) {
                $decoded = json_decode($validated['ministries'], true);
                $validated['ministries'] = is_array($decoded) ? $decoded : null;
            }

            // Convertir cadenas vacías a null para evitar errores de tipo en BD
            // (MySQL rechaza '' en columnas date, decimal, integer, etc.)
            $validated = array_map(
                fn($v) => (is_string($v) && trim($v) === '') ? null : $v,
                $validated
            );

            $this->seen[$keyNorm] = true;
            $this->toCreate[] = $validated;
        }

        // === TRANSACCIÓN: todo o nada para evitar datos corruptos ===
        if (!empty($this->toCreate)) {
            DB::transaction(function () {
                foreach ($this->toCreate as $data) {
                    Iglesia::create($data);
                }
            });

            $this->created = count($this->toCreate);
        }
    }
}