<?php

namespace Modules\Kaprodi\Interfaces;

use Modules\Kaprodi\DataTransferObjects\PenelitianDto;

interface PenelitianServiceInterface
{
    public function getAllPenelitian(array $options);
    public function getPenelitianById(string $id);
    public function approvedPenelitian(string $id);
    public function canceledPenelitian(string $id);

    // public function insertPenelitian(PenelitianDto $request);
    // public function updatePenelitian(string $id, PenelitianDto $request);
    // public function deletePenelitian(string $id);
}
