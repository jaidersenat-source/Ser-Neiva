<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IglesiaRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            // ── Sección 1: Información de la Iglesia ─────────
            'official_name'         => ['required', 'string', 'max:200'],
            'denomination'          => ['required', 'string', 'max:150'],
            'confessional_character'=> ['nullable', 'string', 'max:100'],
            'church_status'         => ['required', 'in:Active,Inactive,Suspended'],
            'foundation_date'       => ['nullable', 'date', 'before_or_equal:today'],
            'specific_location'     => ['nullable', 'string', 'max:255'],
            'approx_members'        => ['nullable', 'integer', 'min:0', 'max:999999'],

            // ── Sección 2: Ubicación ─────────────────────────
            'address'               => ['required', 'string', 'max:255'],
            'neighborhood'          => ['nullable', 'string', 'max:100'],
            'municipality'          => ['nullable', 'string', 'max:100'],
            'comuna'                => ['nullable', 'string', 'max:100'],
            'city'                  => ['nullable', 'string', 'max:100'],
            'department'            => ['nullable', 'string', 'max:100'],
            'country'               => ['nullable', 'string', 'max:80'],

            // ── Sección 3: Contacto ───────────────────────────
            'phone_landline'        => ['nullable', 'string', 'max:20'],
            'phone_mobile'          => ['nullable', 'string', 'max:20'],
            'email'                 => ['nullable', 'email', 'max:150'],
            'correo_institucional'  => ['nullable', 'email', 'max:150'],
            'website_or_social'     => ['nullable', 'string', 'max:255'],

            // ── Sección 4: Pastor ─────────────────────────────
            'pastor_full_name'      => ['nullable', 'string', 'max:150'],
            'pastor_document_type'  => ['nullable', 'string', 'max:20'],
            'pastor_document_number'=> ['nullable', 'string', 'max:30'],
            'pastor_birth_date'     => ['nullable', 'date', 'before:today', 'after:1900-01-01'],
            'leadership_period_type'=> ['nullable', 'string', 'max:50'],
            'pastor_phone'          => ['nullable', 'string', 'max:20'],
            'pastor_email'          => ['nullable', 'email', 'max:150'],

            // ── Sección 5: Líder de mujeres ───────────────────
            'women_leader_full_name'=> ['nullable', 'string', 'max:150'],
            'women_leader_phone'    => ['nullable', 'string', 'max:20'],
            'women_leader_email'    => ['nullable', 'email', 'max:150'],

            // ── Sección 6: Datos jurídicos ────────────────────
            'legal_registration_type'  => ['nullable', 'string', 'max:100'],
            'legal_registration_number'=> ['nullable', 'string', 'max:50'],
            'legal_entity_granting'    => ['nullable', 'string', 'max:200'],
            'resolution_number'        => ['nullable', 'string', 'max:80'],
            'resolution_date'          => ['nullable', 'date'],
            'file_number'              => ['nullable', 'string', 'max:80'],
            'legal_personality_type'   => ['nullable', 'string', 'max:50'],
            'legal_notes'              => ['nullable', 'string', 'max:2000'],

            // ── Sección 7 y 8 ────────────────────────────────
            'ministries'            => ['nullable', 'array'],
            'ministries.*'          => ['string'],
            'additional_notes'      => ['nullable', 'string', 'max:3000'],
            'schedule_weekdays'     => ['nullable', 'string', 'max:100'],
            'schedule_weekends'     => ['nullable', 'string', 'max:100'],

            // ── Geolocalización ───────────────────────────────
            'latitud'  => ['required', 'numeric', 'between:-90,90'],
            'longitud' => ['required', 'numeric', 'between:-180,180'],

            // ── Foto ─────────────────────────────────────────────
            'photo'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],

            // ── Ayudas ────────────────────────────────────────
            'ayudas'   => ['nullable', 'array'],
            'ayudas.*' => ['integer', 'exists:ayudas,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'official_name.required' => 'El nombre oficial de la iglesia es obligatorio.',
            'denomination.required'  => 'La denominación es obligatoria.',
            'church_status.required' => 'El estado de la iglesia es obligatorio.',
            'church_status.in'       => 'El estado debe ser Activa, Inactiva o Suspendida.',
            'address.required'       => 'La dirección es obligatoria.',
            'approx_members.integer' => 'El número de miembros debe ser un entero.',
            'approx_members.min'     => 'El número de miembros no puede ser negativo.',
            'approx_members.max'     => 'El número de miembros no puede superar 999.999.',
            'email.email'                  => 'El correo electrónico no tiene formato válido.',
            'correo_institucional.email'   => 'El correo institucional no tiene formato válido.',
            'pastor_email.email'           => 'El correo del pastor no tiene formato válido.',
            'pastor_birth_date.date'  => 'La fecha de nacimiento del pastor no es válida.',
            'pastor_birth_date.before'=> 'La fecha de nacimiento debe ser anterior a hoy.',
            'pastor_birth_date.after' => 'La fecha de nacimiento no puede ser anterior a 1900.',
            'women_leader_email.email'=> 'El correo de la líder de mujeres no tiene formato válido.',
            'latitud.required'       => 'La latitud es obligatoria.',
            'latitud.between'        => 'La latitud debe estar entre -90 y 90.',
            'longitud.required'      => 'La longitud es obligatoria.',
            'longitud.between'       => 'La longitud debe estar entre -180 y 180.',
            'ayudas.*.exists'        => 'Una o más ayudas seleccionadas no existen.',
        ];
    }

    /** IDs de ayudas del request (array vacío si no se envió nada). */
    public function ayudasIds(): array
    {
        return $this->input('ayudas', []);
    }
}