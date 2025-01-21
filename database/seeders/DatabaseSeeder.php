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
        $this->call([
            FacultySeeder::class,
            UserSeeder::class,
            JenisIndeksasiSeeder::class,
            JenisPenelitianSeeder::class,
            JenisPengabdianSeeder::class,
            NomorDokumenSeeder::class,
        ]);
    }
}
