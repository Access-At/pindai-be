<?php

namespace Modules\Dosen\Interfaces;

use Modules\Dosen\DataTransferObjects\PublikasiDto;

interface PublikasiServiceInterface
{
    public function getAllPublikasi(array $options);

    public function getPublikasiById(string $id);

    public function insertPublikasi(PublikasiDto $request);

    public function updatePublikasi(string $id, PublikasiDto $request);

    public function deletePublikasi(string $id);
}
