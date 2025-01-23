<?php

namespace Modules\Dosen\Interfaces;

use Modules\Dosen\DataTransferObjects\DokumentDownloadDto;
use Modules\Dosen\DataTransferObjects\DokumentUploadDto;

interface DokumentServiceInterface
{
    public function download(DokumentDownloadDto $request, string $id);
    public function upload(DokumentUploadDto $request, string $id);
}
