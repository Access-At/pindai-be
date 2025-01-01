<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisIndeksasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'jenis' => 'Jurnal Ilmiah International Bereputasi',
                'kriteria' => [
                    'Scopus Q1 / WoS',
                    'Scopus Q2',
                    'Scopus Q3',
                    'Scopus Q4'
                ],
                'Keterangan' => 'Sesuai dengan ketentuan proposal'
            ],
            [
                'jenis' => 'Jurnal International',
                'kriteria' => [
                    'Ketentuan Jurnal Internasional sesuai dengan Kepmendikbudristek No 384/P/2024'
                ],
                'Keterangan' => 'Semua Jabatan Fungsional'
            ],
            [
                'jenis' => 'Jurnal Nasional Terakreditasi SINTA',
                'kriteria' => [
                    'S1',
                    'S2',
                    'S3',
                    'S4'
                ],
                'Keterangan' => 'Semua Jabatan Fungsional'
            ],
            [
                'jenis' => 'Conference',
                'kriteria' => [
                    'International Conference (Scopus Indexed)',
                    'National Conference'
                ],
                'Keterangan' => 'Harus sesuai dengan tema bidang penelitian'
            ],
            [
                'jenis' => 'Jurnal Pengabdian',
                'kriteria' => [
                    'Jurnal Nasional Terakreditasi SINTA',
                    'Jurnal Non-Terakreditasi'
                ],
                'Keterangan' => 'Dikhususkan untuk kegiatan pengabdian masyarakat'
            ],
            [
                'jenis' => 'Prosiding',
                'kriteria' => [
                    'Indexed by Scopus',
                    'Indexed by WoS',
                    'Non-Indexed'
                ],
                'Keterangan' => 'Harus terindeks sesuai bidang penelitian'
            ]
        ];

        foreach ($data as $key => $value) {
            \App\Models\JenisIndeksasi::create($value);
        }
    }
}
