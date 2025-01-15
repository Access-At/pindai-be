<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JenisPenelitianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenis = [
            [
                'jenis' => 'Penelitian',
                'kriteria' => [
                    'Target Luaran Publikasi Jurnal Ter Akreditasi Sinta 1 s/d 4 atau International Conference terindeks',
                ],
                'Keterangan' => 'Semua Jabatan Fungsional',
            ],
            [
                'jenis' => 'Penelitian Internasional',
                'kriteria' => [
                    'Target Luaran Publikasi Jurnal Internasional Bereputasi',
                ],
                'Keterangan' => 'Minimal Lektor',
            ],
            [
                'jenis' => 'Penelitian Kerjasama Luar Negeri',
                'kriteria' => [
                    'Target Luaran Jurnal Internasional Bereputasi',
                    'Memiliki MoU, MoA, dan IA Kerjasama',
                ],
                'Keterangan' => 'Minimal Lektor',
            ],
            [
                'jenis' => 'Penelitian Kerjasama Dalam Negeri',
                'kriteria' => [
                    'Target Luaran Publikasi Sinta 1 s/d 3',
                    'Target Luaran Jurnal Internasional Bereputasi',
                    'Jurnal International Bereputasi',
                ],
                'Keterangan' => 'Minimal Asisten Ahli',
            ],
            [
                'jenis' => 'Penelitian Mandiri',
                'kriteria' => [
                    'Target Publikasi Jurnal Nasional Terakreditasi 5 dan 6',
                ],
                'Keterangan' => 'Tenaga Pengajar',
            ],
        ];

        foreach ($jenis as $key => $value) {
            \App\Models\JenisPenelitian::create($value);
        }
    }
}
