<?php

namespace Modules\Dosen\Interfaces;

use Modules\Dosen\DataTransferObjects\DokumentUploadDto;
use Modules\Dosen\DataTransferObjects\DokumentDownloadDto;

interface DokumentServiceInterface
{
    public function download(DokumentDownloadDto $request, string $id);

    public function upload(DokumentUploadDto $request, string $id);
}
