<?php

namespace Modules\Kaprodi\Interfaces;

use Modules\Kaprodi\DataTransferObjects\PengabdianDto;

interface PengabdianServiceInterface
{
    public function getAllPengabdian(array $options);

    public function getPengabdianById(string $id);

    public function approvedPengabdian(string $id);

    public function canceledPengabdian(PengabdianDto $request, string $id);

    // public function insertPengabdian(PengabdianDto $request);
    // public function updatePengabdian(string $id, PengabdianDto $request);
    // public function deletePengabdian(string $id);
}
