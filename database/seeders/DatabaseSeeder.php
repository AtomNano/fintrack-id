<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil CategorySeeder
        $this->call([
            CategorySeeder::class,
        ]);

        // Opsional: Buat user admin
        \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@fintrack.id',
            'role' => 'admin',
        ]);

        // Opsional: Buat user biasa
         \App\Models\User::factory()->create([
             'name' => 'Test User',
             'email' => 'user@fintrack.id',
             'role' => 'user',
         ]);
    }
}
