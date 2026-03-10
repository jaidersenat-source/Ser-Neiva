<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IglesiaRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            // ── Información básica ────────────────────────────
            'nombre'        => ['required', 'string', 'max:200'],
            'denominacion'  => ['required', 'string', 'max:150'],
            'direccion'     => ['required', 'string', 'max:255'],
            'comuna'        => ['nullable', 'string', 'max:100'],
            'corregimiento' => ['nullable', 'string', 'max:100'],
            'estado'        => ['required', 'in:activo,inactivo'],

            // ── Nuevos – Información básica ───────────────────
            'celular_institucional'       => ['nullable', 'string', 'max:20'],
            'correo_institucional'        => ['nullable', 'email', 'max:150'],
            'entidad_registrada_colombia' => ['required', 'in:SI,NO,EN_PROCESO'],
            'promedio_asistentes'         => ['nullable', 'integer', 'min:0', 'max:999999'],

            // ── Contacto y responsable ────────────────────────
            'pastor_sacerdote'       => ['nullable', 'string', 'max:150'],
            'fecha_nacimiento_lider' => ['nullable', 'date', 'before:today', 'after:1900-01-01'],
            'telefono'               => ['nullable', 'string', 'max:20'],
            'email'                  => ['nullable', 'email', 'max:150'],
            'descripcion'            => ['nullable', 'string', 'max:2000'],

            // ── Geolocalización ───────────────────────────────
            'latitud'  => ['required', 'numeric', 'between:-90,90'],
            'longitud' => ['required', 'numeric', 'between:-180,180'],

            // ── Ayudas ────────────────────────────────────────
            'ayudas'   => ['nullable', 'array'],
            'ayudas.*' => ['integer', 'exists:ayudas,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'                      => 'El nombre de la iglesia es obligatorio.',
            'denominacion.required'                => 'La denominación es obligatoria.',
            'direccion.required'                   => 'La dirección es obligatoria.',
            'estado.in'                            => 'El estado debe ser activo o inactivo.',
            'correo_institucional.email'           => 'El correo institucional no tiene formato válido.',
            'entidad_registrada_colombia.required' => 'Indica si la entidad está registrada en Colombia.',
            'entidad_registrada_colombia.in'       => 'El valor debe ser SI, NO o EN_PROCESO.',
            'promedio_asistentes.integer'          => 'El promedio de asistentes debe ser un número entero.',
            'promedio_asistentes.min'              => 'El promedio no puede ser negativo.',
            'promedio_asistentes.max'              => 'El promedio no puede superar 999.999.',
            'fecha_nacimiento_lider.date'          => 'La fecha de nacimiento no es válida.',
            'fecha_nacimiento_lider.before'        => 'La fecha de nacimiento debe ser anterior a hoy.',
            'fecha_nacimiento_lider.after'         => 'La fecha de nacimiento no puede ser anterior a 1900.',
            'email.email'                          => 'El correo de contacto no tiene formato válido.',
            'latitud.required'                     => 'La latitud es obligatoria.',
            'latitud.between'                      => 'La latitud debe estar entre -90 y 90.',
            'longitud.required'                    => 'La longitud es obligatoria.',
            'longitud.between'                     => 'La longitud debe estar entre -180 y 180.',
            'ayudas.*.exists'                      => 'Una o más ayudas seleccionadas no existen.',
        ];
    }

    /** IDs de ayudas del request (array vacío si no se envió nada). */
    public function ayudasIds(): array
    {
        return $this->input('ayudas', []);
    }
}