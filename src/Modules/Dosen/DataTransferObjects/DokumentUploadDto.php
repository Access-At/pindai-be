<?php

namespace Modules\Dosen\DataTransferObjects;

use Modules\Dosen\Requests\DokumentUploadRequest;

class DokumentUploadDto
{
    public function __construct(
        public array $file
    ) {}

    public static function fromRequest(DokumentUploadRequest $request): self
    {
        return new self(
            $request->validated('file'),
        );
    }
}
