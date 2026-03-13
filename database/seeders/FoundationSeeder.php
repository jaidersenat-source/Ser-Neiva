<?php

namespace Database\Seeders;

use App\Models\Foundation;
use Illuminate\Database\Seeder;

class FoundationSeeder extends Seeder
{
    public function run(): void
    {
        $foundations = [
            [
                'name'           => 'FUNDACIÓN BEERSEBA',
                'nit'            => '900.949.364-4',
                'representative' => 'Haner Conde Bustamante',
                'document'       => '7.698.874',
                'phone'          => '3115915165',
                'email'          => 'beersebaadm@gmail.com',
                'address'        => 'Cra 3A #12-20 El Centro',
                'latitude'       => 2.9344,
                'longitude'      => -75.2891,
            ],
            [
                'name'           => 'FUNDACIÓN DE APOYO A FAMILIAS EN CONFLICTO - FUNDAFE',
                'nit'            => '900.236.588-7',
                'representative' => 'Gloria Adriana Adarve Quintero',
                'document'       => '66.846.237',
                'phone'          => '3167752516',
                'email'          => 'contadorfundafe@gmail.com',
                'address'        => 'Cra 6 #43-67 Las Granjas',
                'latitude'       => 2.9120,
                'longitude'      => -75.2738,
            ],
            [
                'name'           => 'FUNDACIÓN PICACHOS NEIVA',
                'nit'            => null,
                'representative' => 'Claudia Prieto Bahamón',
                'document'       => null,
                'phone'          => '3007173732',
                'email'          => 'rsfpicachos@gmail.com',
                'address'        => 'Calle 58 #1W-65',
                'latitude'       => 2.8971,
                'longitude'      => -75.2779,
            ],
        ];

        foreach ($foundations as $data) {
            Foundation::firstOrCreate(['name' => $data['name']], $data);
        }
    }
}
