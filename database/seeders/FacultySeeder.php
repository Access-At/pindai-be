<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faculties = [
            'Fakultas Ilmu Komputer',
            'Fakultas Ekonomi dan Bisnis',
            'Fakultas Ilmu Sosial dan Ilmu Politik',
            'Fakultas Ilmu Budaya',
            'Fakultas Ilmu Kesehatan',
            'Fakultas Teknik',
            'Fakultas Pertanian',
            'Fakultas Ilmu Sosial dan Ilmu Politik',
            'Fakultas Ilmu Budaya',
            'Fakultas Ilmu Kesehatan',
            'Fakultas Teknik',
            'Fakultas Pertanian',
            'Fakultas Ilmu Sosial dan Ilmu Politik',
            'Fakultas Ilmu Budaya',
            'Fakultas Ilmu Kesehatan',
            'Fakultas Teknik',
            'Fakultas Pertanian',
            'Fakultas Ilmu Sosial dan Ilmu Politik',
            'Fakultas Ilmu Budaya',
        ];

        foreach ($faculties as $faculty) {
            \App\Models\Faculty::create([
                'name' => $faculty,
            ]);
        }
    }
}
