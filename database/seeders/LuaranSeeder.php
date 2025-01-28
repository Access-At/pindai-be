<?php

namespace Database\Seeders;

use App\Models\Luaran;
use App\Helper\Terbilang;
use App\Models\LuaranKriteria;
use Illuminate\Database\Seeder;

class LuaranSeeder extends Seeder
{
    private $terbilang;

    // harus sama category dengan Luaran ini
    // case Penelitian = 'penelitian';
    // case Pengabdian = 'pengabdian';
    // case Publikasi = 'publikasi';
    // case Buku = 'buku';
    // case Intelektual = 'intelektual';

    public function __construct()
    {
        $this->terbilang = new Terbilang;
    }

    public function run(): void
    {
        $this->seedPenelitian();
        $this->seedPengabdian();
        $this->seedPublikasi();
    }

    private function createLuaranAndKriteria(string $category, array $data): void
    {
        $luaran = Luaran::create([
            'category' => $category,
            'name' => $data['name'],
        ]);

        foreach ($data['kriteria'] as $kriteria) {
            $this->terbilang->parse($kriteria['nominal']);

            LuaranKriteria::create([
                'name' => $kriteria['name'],
                'nominal' => $kriteria['nominal'],
                'terbilang' => $this->terbilang->getResult(),
                'keterangan' => $kriteria['keterangan'],
                'luaran_id' => $luaran->id,
            ]);
        }
    }

    private function seedPenelitian(): void
    {
        $penelitianData = [
            [
                'name' => 'Penelitian Pemula',
                'kriteria' => [
                    [
                        'name' => 'Target Luaran Publikasi Jurnal Ter Akreditasi Sinta 1 s.d 4 atau International Conference terindeks',
                        'nominal' => 2000000,
                        'keterangan' => 'Semua Jabatan Fungsional',
                    ],
                ],
            ],
            [
                'name' => 'Penelitian Internasional',
                'kriteria' => [
                    [
                        'name' => 'Target Luaran Publikasi Jurnal Internasional Bereputasi',
                        'nominal' => 5000000,
                        'keterangan' => 'Minimal Lektor',
                    ],
                ],
            ],
            [
                'name' => 'Penelitian Kerjasama Luar Negeri',
                'kriteria' => [
                    [
                        'name' => 'Target Luaran Jurnal Internasional Bereputasi',
                        'nominal' => 6000000,
                        'keterangan' => 'Minimal Lektor',
                    ],
                    [
                        'name' => 'Memiliki MoU, MoA, dan IA Kerjasama',
                        'nominal' => 6000000,
                        'keterangan' => 'Minimal Lektor',
                    ],
                ],
            ],
            [
                'name' => 'Penelitian Kerjasama Dalam Negeri',
                'kriteria' => [
                    [
                        'name' => 'Target Luaran Publikasi Sinta 1 s.d 3 - Memiliki MoU, MoA, dan IA Kerjasama',
                        'nominal' => 2500000,
                        'keterangan' => 'Minimal Asisten Ahli',
                    ],
                    [
                        'name' => 'Jurnal International Bereputasi - Memiliki MoU, MoA, dan IA Kerjasama',
                        'nominal' => 5000000,
                        'keterangan' => 'Minimal Asisten Ahli',
                    ],
                ],
            ],
            [
                'name' => 'Penelitian Mandiri',
                'kriteria' => [
                    [
                        'name' => 'Target Publikasi Jurnal Nasional Terakreditasi 5 dan 6',
                        'nominal' => 1000000,
                        'keterangan' => 'Tenaga Pengajar',
                    ],
                ],
            ],
        ];

        foreach ($penelitianData as $data) {
            $this->createLuaranAndKriteria('penelitian', $data);
        }
    }

    private function seedPengabdian(): void
    {
        $pengabdianData = [
            [
                'name' => 'Proposal Pengabdian',
                'kriteria' => [
                    [
                        'name' => 'Minimal 3 Dosen dari 2 Prodi yang berbeda dalam satu intitusi',
                        'nominal' => 1000000,
                        'keterangan' => 'Semua Jabatan Fungsional',
                    ],
                ],
            ],
            [
                'name' => 'Proposal Pengabdian Kerjasama Dalam Negeri',
                'kriteria' => [
                    [
                        'name' => 'Minimal 2 Dosen UPB dari Prodi yang berbeda dari lingkup LLDIKti IV dan sudah mempunyai MoU, MoA, IA',
                        'nominal' => 2000000,
                        'keterangan' => 'Semua Jabatan Fungsional',
                    ],
                ],
            ],
            [
                'name' => 'Proposal Pengabdian Kerjasama Luar Negeri',
                'kriteria' => [
                    [
                        'name' => 'Minimal 2 Dosen UPB dari Prodi yang berbeda dan kampus LN yangsudah mempunyai MoU, MoA, IA',
                        'nominal' => 3000000,
                        'keterangan' => 'Semua Jabatan Fungsional',
                    ],
                ],
            ],
        ];

        foreach ($pengabdianData as $data) {
            $this->createLuaranAndKriteria('pengabdian', $data);
        }
    }

    private function seedPublikasi(): void
    {
        $publikasiData = [
            [
                'name' => 'Jurnal Ilmiah Internasional Bereputasi',
                'kriteria' => [
                    [
                        'name' => 'Scopus Q1 / WoS',
                        'nominal' => 1200000,
                        'keterangan' => 'Sesuai dengan ketentuan proposal',
                    ],
                    [
                        'name' => 'Scopus Q2',
                        'nominal' => 1000000,
                        'keterangan' => 'Sesuai dengan ketentuan proposal',
                    ],
                    [
                        'name' => 'Scopus Q3',
                        'nominal' => 800000,
                        'keterangan' => 'Sesuai dengan ketentuan proposal',
                    ],
                    [
                        'name' => 'Scopus Q4',
                        'nominal' => 600000,
                        'keterangan' => 'Sesuai dengan ketentuan proposal',
                    ],
                ],
            ],
            [
                'name' => 'Jurnal Internasional',
                'kriteria' => [
                    [
                        'name' => 'Ketentuan Jurnal Internasional sesuai dengan Kepmendikbudristek No:384/P/2024',
                        'nominal' => 2500000,
                        'keterangan' => 'Sesuai dengan ketentuan proposal',
                    ],
                ],
            ],
            [
                'name' => 'Jurnal Nasional Terakreditasi SINTA',
                'kriteria' => [
                    [
                        'name' => 'S1',
                        'nominal' => 7500000,
                        'keterangan' => 'Semua Jabatan Fungsional',
                    ],
                    [
                        'name' => 'S2',
                        'nominal' => 6000000,
                        'keterangan' => 'Semua Jabatan Fungsional',
                    ],
                    [
                        'name' => 'S3',
                        'nominal' => 3500000,
                        'keterangan' => 'Semua Jabatan Fungsional',
                    ],
                    [
                        'name' => 'S4',
                        'nominal' => 2500000,
                        'keterangan' => 'Semua Jabatan Fungsional',
                    ],
                    [
                        'name' => 'S5 dan S6',
                        'nominal' => 1000000,
                        'keterangan' => 'Khusus Tenaga Pengajar',
                    ],
                ],
            ],
            [
                'name' => 'Conference',
                'kriteria' => [
                    [
                        'name' => 'Internasional terindeks Scopus/WoS',
                        'nominal' => 4000000,
                        'keterangan' => 'Semua Jabatan Fungsional',
                    ],
                ],
            ],
            [
                'name' => 'Jurnal Pengabdian',
                'kriteria' => [
                    [
                        'name' => 'Nasional e-ISSN',
                        'nominal' => 1000000,
                        'keterangan' => 'Semua Jabatan Fungsional',
                    ],
                    [
                        'name' => 'Internasional Terakreditasi SINTA (Semua Level Sinta)',
                        'nominal' => 1500000,
                        'keterangan' => 'Semua Jabatan Fungsional',
                    ],
                ],
            ],
        ];

        foreach ($publikasiData as $data) {
            $this->createLuaranAndKriteria('publikasi', $data);
        }
    }
}
