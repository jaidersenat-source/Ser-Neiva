<?php

namespace App\Imports;

use App\Models\Iglesia;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IglesiasImport implements ToCollection, WithHeadingRow
{
    public int $created = 0;
    public int $skipped = 0;
    public array $errors = [];

    private array $toCreate = [];
    private array $seen = [];

    public function collection(Collection $rows)
    {
        $rules = [
            'nombre'                     => 'required|string|max:255',
            'denominacion'               => 'nullable|string|max:150',
            'direccion'                  => 'required|string|max:500',
            'comuna'                     => 'nullable|string|max:50',
            'corregimiento'              => 'nullable|string|max:100',
            'estado'                     => 'nullable|string|max:20',
            'celular_institucional'      => 'nullable|string|max:20',
            'correo_institucional'       => 'nullable|email:rfc,dns|max:255',
            'entidad_registrada_colombia'=> 'nullable|string|max:30',
            'promedio_asistentes'        => 'nullable|integer|min:0',
            'pastor_sacerdote'           => 'nullable|string|max:150',
            'fecha_nacimiento_lider'     => 'nullable|date',
            'telefono'                   => 'nullable|string|max:20',
            'email'                      => 'nullable|email:rfc,dns|max:255',
            'descripcion'                => 'nullable|string|max:2000',
            'latitud'                    => 'nullable|numeric',
            'longitud'                   => 'nullable|numeric',
        ];

        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2; // +2 porque fila 1 = encabezados

            // Normalizamos claves a minúsculas (case-insensitive)
            $data = array_change_key_case($row->toArray(), CASE_LOWER);

            $validator = Validator::make($data, $rules);

            if ($validator->fails()) {
                $this->errors[] = [
                    'row'       => $rowNumber,
                    'nombre'    => $data['nombre'] ?? 'N/A',
                    'direccion' => $data['direccion'] ?? 'N/A',
                    'errors'    => $validator->errors()->all(),
                ];
                continue;
            }

            $validated = $validator->validated();

            // Normalización para detección de duplicados (case + trim insensitive)
            $nombreNorm     = trim(strtolower($validated['nombre']));
            $direccionNorm  = trim(strtolower($validated['direccion']));
            $key            = $nombreNorm . '|' . $direccionNorm;

            // Verificar duplicado en el mismo archivo O en BD
            if (isset($this->seen[$key]) ||
                Iglesia::whereRaw('LOWER(nombre) = ?', [$nombreNorm])
                       ->whereRaw('LOWER(direccion) = ?', [$direccionNorm])
                       ->exists()) {
                $this->skipped++;
                continue;
            }

            $this->seen[$key] = true;
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