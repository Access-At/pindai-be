<?php

namespace Modules\Keuangan\Interfaces;

use Modules\Keuangan\DataTransferObjects\PengabdianDto;

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
