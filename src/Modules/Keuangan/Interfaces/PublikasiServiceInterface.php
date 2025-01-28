<?php

namespace Modules\Keuangan\Interfaces;

use Modules\Keuangan\DataTransferObjects\PublikasiDto;

interface PublikasiServiceInterface
{
    public function getAllPublikasi(array $options);

    public function getPublikasiById(string $id);

    public function approvedPublikasi(string $id);

    public function canceledPublikasi(PublikasiDto $request, string $id);

    // public function insertPublikasi(PublikasiDto $request);
    // public function updatePublikasi(string $id, PublikasiDto $request);
    // public function deletePublikasi(string $id);
}
