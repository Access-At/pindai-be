<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NomorDokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // /7/Und/UPB/2025 (Undangan)
        // /7/SA/UPB/2025 (Surat Ajuan)
        // /7/SE/UPB/2025 (Surat Edaran)
        // /7/ST/UPB/2025 (Surat Tugas)
        // /7/SR/UPB/2025 (Surat Rekomendasi)
        // /7/SK/UPB/2025 (Surat Keputusan)
        // /7/Ket/UPB/2025 (Keterangan)
        // /7/SP/UPB/2025 (Surat Pengantar)

        $kodeDokumen = [
            "Und" => "surat_undangan",
            "SA" => "surat_ajuan",
            "SE" => "surat_edaran",
            "ST" => "surat_tugas",
            "SR" => "surat_rekomendasi",
            "SK" => "surat_keputusan",
            "Ket" => "surat_keterangan",
            "SP" => "surat_pengantar",
        ];

        foreach ($kodeDokumen as $key => $value) {
            \App\Models\NomorDokumen::create([
                'nomor' => '000',
                'kode_dokumen' => $key,
                'jenis_dokumen' => $value,
                'tahun_dokumen' => date('Y'),
            ]);
        }
    }
}
