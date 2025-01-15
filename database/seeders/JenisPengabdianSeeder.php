<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class JenisPengabdianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenis = [
            [
                'jenis' => 'Pengabdian Masyarakat',
                'kriteria' => [
                    'Target Luaran Publikasi Jurnal Nasional Terakreditasi Sinta 1 s/d 6',
                    'Pelaksanaan kegiatan berbasis masyarakat',
                ],
                'Keterangan' => 'Semua Jabatan Fungsional',
            ],
            [
                'jenis' => 'Pengabdian Berbasis Internasional',
                'kriteria' => [
                    'Target Luaran Publikasi Jurnal Internasional Bereputasi',
                    'Melibatkan kolaborasi dengan mitra internasional',
                ],
                'Keterangan' => 'Minimal Lektor',
            ],
            [
                'jenis' => 'Pengabdian Kerjasama Luar Negeri',
                'kriteria' => [
                    'Target Luaran Publikasi Jurnal Internasional Bereputasi',
                    'Memiliki MoU, MoA, dan IA Kerjasama',
                ],
                'Keterangan' => 'Minimal Lektor',
            ],
            [
                'jenis' => 'Pengabdian Kerjasama Dalam Negeri',
                'kriteria' => [
                    'Target Luaran Publikasi Sinta 1 s/d 3',
                    'Melibatkan mitra lokal atau institusi pemerintah',
                ],
                'Keterangan' => 'Minimal Asisten Ahli',
            ],
            [
                'jenis' => 'Pengabdian Mandiri',
                'kriteria' => [
                    'Target Luaran Publikasi Jurnal Nasional Terakreditasi Sinta 4 s/d 6',
                    'Pelaksanaan berbasis inisiatif individu atau kelompok',
                ],
                'Keterangan' => 'Tenaga Pengajar',
            ],
        ];

        foreach ($jenis as $key => $value) {
            \App\Models\JenisPengabdian::create($value);
        }
    }
}
