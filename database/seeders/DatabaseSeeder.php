<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'Administrador 2',
            'email' => 'admin2@admin.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'Recepcionista',
            'email' => 'recepcionista@admin.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'Esteticista 1',
            'email' => 'esteticista1@admin.com',
            'password' => Hash::make('12345678'),
        ]);

        User::create([
            'name' => 'Esteticista 2',
            'email' => 'esteticista2@admin.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
