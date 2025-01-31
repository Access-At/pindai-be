<?php

namespace Modules\Dosen\DataTransferObjects;

use Modules\Dosen\Requests\DokumentUploadRequest;

class DokumentUploadDto
{
    public function __construct(
        public string $file,
        public string $category,
        public ?string $jenis_dokumen
    ) {}

    public static function fromRequest(DokumentUploadRequest $request): self
    {
        return new self(
            $request->validated('file'),
            $request->validated('category'),
            $request->validated('jenis_dokumen')
        );
    }
}
