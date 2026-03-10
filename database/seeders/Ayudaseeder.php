<?php

namespace Database\Seeders;

use App\Models\Ayuda;
use Illuminate\Database\Seeder;

class AyudaSeeder extends Seeder
{
    public function run(): void
    {
        $ayudas = [
            ['nombre' => 'Banco de Alimentos',        'icono' => '🍞', 'color' => '#F59E0B', 'descripcion' => 'Distribución de alimentos a familias vulnerables.'],
            ['nombre' => 'Ropa y Calzado',            'icono' => '👕', 'color' => '#3B82F6', 'descripcion' => 'Donación de prendas de vestir y calzado.'],
            ['nombre' => 'Apoyo Psicológico',         'icono' => '🧠', 'color' => '#8B5CF6', 'descripcion' => 'Orientación y acompañamiento psicosocial.'],
            ['nombre' => 'Educación y Tutorías',      'icono' => '📚', 'color' => '#0891B2', 'descripcion' => 'Refuerzo escolar y talleres educativos.'],
            ['nombre' => 'Atención Médica',           'icono' => '🏥', 'color' => '#EF4444', 'descripcion' => 'Jornadas de salud, brigadas médicas y odontológicas.'],
            ['nombre' => 'Adulto Mayor',              'icono' => '👴', 'color' => '#10B981', 'descripcion' => 'Programas de acompañamiento para personas mayores.'],
            ['nombre' => 'Niñez y Juventud',         'icono' => '🧒', 'color' => '#F97316', 'descripcion' => 'Actividades recreativas y formación para jóvenes.'],
            ['nombre' => 'Empleo y Emprendimiento',   'icono' => '💼', 'color' => '#6366F1', 'descripcion' => 'Orientación laboral y formación para el emprendimiento.'],
            ['nombre' => 'Población Migrante',        'icono' => '🌍', 'color' => '#14B8A6', 'descripcion' => 'Atención integral a familias migrantes.'],
            ['nombre' => 'Rehabilitación',            'icono' => '♻️', 'color' => '#84CC16', 'descripcion' => 'Programas de rehabilitación de sustancias psicoactivas.'],
        ];

        foreach ($ayudas as $ayuda) {
            Ayuda::firstOrCreate(['nombre' => $ayuda['nombre']], $ayuda);
        }

        $this->command->info('✅ Ayudas sociales creadas: ' . count($ayudas));
    }
}