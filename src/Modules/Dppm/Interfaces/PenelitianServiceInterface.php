<?php

namespace Modules\Dppm\Interfaces;

use Modules\Dppm\DataTransferObjects\PenelitianDto;

interface PenelitianServiceInterface
{
    public function getAllPenelitian(array $options);

    public function getPenelitianById(string $id);

    public function approvedPenelitian(string $id);

    public function canceledPenelitian(PenelitianDto $request, string $id);

    // public function insertPenelitian(PenelitianDto $request);
    // public function updatePenelitian(string $id, PenelitianDto $request);
    // public function deletePenelitian(string $id);
}
