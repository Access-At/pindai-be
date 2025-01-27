<?php

namespace Modules\Dosen\DataTransferObjects;

use Modules\Dosen\Requests\PublikasiRequest;

class PublikasiDto
{
    public function __construct(
        public string $judul,
        public string $jenis_publikasi,
        public string $tanggal_publikasi,
        public string $tahun,
        public string $author,
        public string $jurnal,
        public string $link_publikasi,
        public string $luaran_kriteria,
    ) {}

    public static function fromRequest(PublikasiRequest $request): self
    {
        return new self(
            $request->validated('judul'),
            $request->validated('jenis_publikasi'),
            $request->validated('tanggal_publikasi'),
            $request->validated('tahun'),
            $request->validated('author'),
            $request->validated('jurnal'),
            $request->validated('link_publikasi'),
            $request->validated('luaran_kriteria'),
        );
    }
}
