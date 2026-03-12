<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SportsVenueRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'                   => ['required', 'string', 'max:200'],
            'address'                => ['required', 'string', 'max:255'],
            'latitude'               => ['required', 'numeric', 'between:-90,90'],
            'longitude'              => ['required', 'numeric', 'between:-180,180'],
            'contact'                => ['nullable', 'string', 'max:100'],
            'available_for_churches' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'      => 'El nombre del escenario es obligatorio.',
            'address.required'   => 'La dirección es obligatoria.',
            'latitude.required'  => 'La latitud es obligatoria.',
            'latitude.between'   => 'La latitud debe estar entre -90 y 90.',
            'longitude.required' => 'La longitud es obligatoria.',
            'longitude.between'  => 'La longitud debe estar entre -180 y 180.',
        ];
    }
}
