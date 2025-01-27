<?php

namespace Modules\Dosen\Interfaces;

use Modules\Dosen\DataTransferObjects\PengabdianDto;

interface PengabdianServiceInterface
{
    public function getAllPengabdian(array $options);

    public function getPengabdianById(string $id);

    public function insertPengabdian(PengabdianDto $request);

    public function updatePengabdian(string $id, PengabdianDto $request);

    public function deletePengabdian(string $id);
}
