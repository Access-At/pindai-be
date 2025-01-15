<?php

namespace Modules\Dosen\DataTransferObjects;

use Modules\Dosen\Requests\DokumentRequest;

class DokumentDto
{
    public function __construct(
        public string $jenis_dokument
    ) {}

    public static function fromRequest(DokumentRequest $request): self
    {
        return new self(
            $request->validated('jenis_dokument'),
        );
    }
}
