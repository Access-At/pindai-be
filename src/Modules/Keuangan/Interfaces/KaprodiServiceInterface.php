<?php

namespace Modules\Keuangan\Interfaces;

use Modules\Keuangan\DataTransferObjects\KaprodiDto;

interface KaprodiServiceInterface
{
    public function getAllKaprodi(array $options);

    public function getKaprodiById(string $id);

    public function insertKaprodi(KaprodiDto $requst);

    public function updateKaprodi(string $faculty, KaprodiDto $request);

    public function deleteKaprodi(string $faculty);
}
