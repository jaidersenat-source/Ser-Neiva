<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EditorHuilaSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'editor.huila@sirn.gov.co'],
            [
                'name'     => 'Editor Huila',
                'email'    => 'editor.huila@sirn.gov.co',
                'password' => Hash::make('EditorHuila2024*'),
                'role'     => 'editor_huila',
            ]
        );
    }
}
