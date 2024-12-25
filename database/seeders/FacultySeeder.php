<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faculties = [
            'Fakultas Ilmu Komputer' => ['Teknik Informatika', 'Sistem Informasi'],
            'Fakultas Ekonomi dan Bisnis' => ['Manajemen', 'Akuntansi', 'Ekonomi Pembangunan'],
            'Fakultas Ilmu Sosial dan Ilmu Politik' => ['Ilmu Komunikasi', 'Administrasi Publik', 'Hubungan Internasional'],
            'Fakultas Ilmu Budaya' => ['Sastra Indonesia', 'Sastra Inggris', 'Sastra Jepang'],
            'Fakultas Ilmu Kesehatan' => ['Keperawatan', 'Kesehatan Masyarakat', 'Farmasi'],
            'Fakultas Teknik' => ['Teknik Sipil', 'Teknik Elektro', 'Teknik Mesin'],
            'Fakultas Pertanian' => ['Agroteknologi', 'Agribisnis', 'Teknologi Pangan'],
        ];

        foreach ($faculties as $faculty => $studyPrograms) {
            $facultyModel = \App\Models\Faculty::create([
                'name' => $faculty,
            ]);

            foreach ($studyPrograms as $program) {
                \App\Models\Prodi::create([
                    'faculties_id' => $facultyModel->id,
                    'name' => $program,
                ]);
            }
        }
    }
}
