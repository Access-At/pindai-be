<?php

namespace Modules\Dosen\Interfaces;

use Modules\Dosen\DataTransferObjects\PenelitianDto;

interface PenelitianServiceInterface
{
    public function getAllPenelitian(int $perPage, int $page, string $search);
    public function getPenelitianById(string $id);
    public function insertPenelitian(PenelitianDto $request);
    public function updatePenelitian(string $id, PenelitianDto $request);
    // public function deletePenelitian(string $id);
}
