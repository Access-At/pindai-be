<?php

namespace Modules\Dppm\Interfaces;

use Modules\Dppm\DataTransferObjects\KaprodiDto;

interface KaprodiServiceInterface
{
    public function getAllKaprodi(int $perPage, int $page, string $search);
    public function getKaprodiById(string $id);
    public function insertKaprodi(KaprodiDto $requst);
    public function updateKaprodi(string $faculty, KaprodiDto $request);
    public function deleteKaprodi(string $faculty);
}
