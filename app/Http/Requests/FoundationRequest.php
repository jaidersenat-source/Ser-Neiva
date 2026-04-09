<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FoundationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'           => ['required', 'string', 'max:200'],
            'nit'            => ['nullable', 'string', 'max:30'],
            'representative' => ['nullable', 'string', 'max:150'],
            'document'       => ['nullable', 'string', 'max:30'],
            'phone'          => ['nullable', 'string', 'max:30'],
            'email'          => ['nullable', 'email', 'max:150'],
            'address'        => ['nullable', 'string', 'max:255'],
            'latitude'       => ['nullable', 'numeric', 'between:-90,90'],
            'longitude'      => ['nullable', 'numeric', 'between:-180,180'],
            'imagen_principal'=> ['nullable', 'image', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'    => 'El nombre de la fundación es obligatorio.',
            'email.email'      => 'El correo electrónico no tiene un formato válido.',
            'latitude.between' => 'La latitud debe estar entre -90 y 90.',
            'longitude.between'=> 'La longitud debe estar entre -180 y 180.',
        ];
    }
}
