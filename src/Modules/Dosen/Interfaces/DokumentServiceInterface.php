<?php

namespace Modules\Dosen\Interfaces;

use App\Models\Penelitian;
use Modules\Dosen\DataTransferObjects\DokumentDto;

interface DokumentServiceInterface
{
    public function download(DokumentDto $request, string $id);
}
