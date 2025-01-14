<?php

namespace Modules\Dosen\Interfaces;

use Illuminate\Http\Request;
use Modules\Dosen\DataTransferObjects\PenelitianDto;

interface PenelitianServiceInterface
{
    public function getAllPenelitian(array $options);
    public function getPenelitianById(string $id);
    public function insertPenelitian(PenelitianDto $request);
    public function updatePenelitian(string $id, PenelitianDto $request);
    // public function deletePenelitian(string $id);
}
