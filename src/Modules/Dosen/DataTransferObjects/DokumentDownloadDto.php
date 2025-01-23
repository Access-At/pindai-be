<?php

namespace Modules\Dosen\DataTransferObjects;

use Modules\Dosen\Requests\DokumentDownloadRequest;

class DokumentDownloadDto
{
    public function __construct(
        public string $jenis_dokumen
    ) {}

    public static function fromRequest(DokumentDownloadRequest $request): self
    {
        return new self(
            $request->validated('jenis_dokumen'),
        );
    }
}
