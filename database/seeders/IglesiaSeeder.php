<?php

namespace Database\Seeders;

// use App\Models\Iglesia; // Commented out to avoid undefined type error
use Illuminate\Database\Seeder;

class IglesiaSeeder extends Seeder
{
    public function run(): void
    {
        $iglesias = [
            [
                'nombre'          => 'Catedral de la Inmaculada Concepción',
                'denominacion'    => 'Católica',
                'direccion'       => 'Calle 8 # 4-37, Centro, Neiva',
                'comuna'          => 'Comuna 1',
                'corregimiento'   => null,
                'latitud'         => 2.9274,
                'longitud'        => -75.2819,
                'pastor_sacerdote'=> 'Monseñor Luis Madrid',
                'telefono'        => '098 871 2345',
                'email'           => 'catedral@diocesisneiva.org',
                'descripcion'     => 'Catedral principal de la Diócesis de Neiva.',
                'estado'          => 'activo',
            ],
            [
                'nombre'          => 'Iglesia Cristiana Comunidad de Fe',
                'denominacion'    => 'Cristiana Evangélica',
                'direccion'       => 'Carrera 5 # 18-20, Neiva',
                'comuna'          => 'Comuna 3',
                'corregimiento'   => null,
                'latitud'         => 2.9310,
                'longitud'        => -75.2850,
                'pastor_sacerdote'=> 'Pastor Juan Hernández',
                'telefono'        => '311 456 7890',
                'email'           => 'comunidadfe@gmail.com',
                'descripcion'     => 'Congregación evangélica fundada en 1995.',
                'estado'          => 'activo',
            ],
            [
                'nombre'          => 'Iglesia Adventista del Séptimo Día',
                'denominacion'    => 'Adventista',
                'direccion'       => 'Avenida Circunvalar # 22-15, Neiva',
                'comuna'          => 'Comuna 5',
                'corregimiento'   => null,
                'latitud'         => 2.9350,
                'longitud'        => -75.2780,
                'pastor_sacerdote'=> 'Pastor Carlos Mejía',
                'telefono'        => '312 987 6543',
                'email'           => 'adventista.neiva@gmail.com',
                'descripcion'     => 'Iglesia Adventista del Séptimo Día Neiva Central.',
                'estado'          => 'activo',
            ],
            [
                'nombre'          => 'Iglesia Pentecostal Unida de Colombia',
                'denominacion'    => 'Pentecostal',
                'direccion'       => 'Calle 15 # 9-30, Neiva',
                'comuna'          => 'Comuna 4',
                'corregimiento'   => null,
                'latitud'         => 2.9290,
                'longitud'        => -75.2900,
                'pastor_sacerdote'=> 'Pastor Armando Torres',
                'telefono'        => '315 234 5678',
                'email'           => 'ipuc.neiva@ipuc.org',
                'descripcion'     => 'Congregación Pentecostal Unida.',
                'estado'          => 'activo',
            ],
            [
                'nombre'          => 'Parroquia San Pedro Apóstol',
                'denominacion'    => 'Católica',
                'direccion'       => 'Barrio Calixto, Neiva',
                'comuna'          => 'Comuna 7',
                'corregimiento'   => null,
                'latitud'         => 2.9400,
                'longitud'        => -75.2750,
                'pastor_sacerdote'=> 'Padre Rodrigo Vargas',
                'telefono'        => '098 874 5678',
                'email'           => 'parroquiasanpedro@neiva.org',
                'descripcion'     => 'Parroquia del barrio Calixto.',
                'estado'          => 'activo',
            ],
        ];

        foreach ($iglesias as $iglesia) {
            \App\Models\Iglesia::create($iglesia);
        }
    }
}