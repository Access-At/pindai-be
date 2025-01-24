<?php

namespace Modules\Dosen\DataTransferObjects;

use Modules\Dosen\Requests\PengabdianRequest;

class PengabdianDto
{
    public function __construct(
        public string $tahun_akademik,
        public string $semester,
        public string $judul,
        public string $deskripsi,
        public string $bidang,
        public string $jenis_pengabdian,
        public string $jenis_indeksasi,
        public array $anggota,
    ) {}

    public static function fromRequest(PengabdianRequest $request): self
    {
        return new self(
            $request->validated('tahun_akademik'),
            $request->validated('semester'),
            $request->validated('judul'),
            $request->validated('deskripsi'),
            $request->validated('bidang'),
            $request->validated('jenis_pengabdian'),
            $request->validated('jenis_indeksasi'),
            $request->validated('anggota')
        );
    }
}
