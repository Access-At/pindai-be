<?php

namespace Modules\Dosen\DataTransferObjects;

use Modules\Dosen\Requests\PenelitianRequest;

class PenelitianDto
{
    public function __construct(
        public string $tahun_akademik,
        public string $semester,
        public string $judul,
        public string $deskripsi,
        public string $bidang,
        public string $luaran_kriteria,
        public array $anggota,
    ) {}

    public static function fromRequest(PenelitianRequest $request): self
    {
        return new self(
            $request->validated('tahun_akademik'),
            $request->validated('semester'),
            $request->validated('judul'),
            $request->validated('deskripsi'),
            $request->validated('bidang'),
            $request->validated('luaran_kriteria'),
            $request->validated('anggota')
        );
    }
}
