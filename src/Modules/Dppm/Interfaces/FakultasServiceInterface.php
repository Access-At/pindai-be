<?php

namespace Modules\Dppm\Interfaces;

use Modules\Dppm\DataTransferObjects\FakultasDto;

interface FakultasServiceInterface
{
    public function getAllFakultas(int $perPage, int $page, string $search);
    public function getFakultasById(string $id);
    public function insertFakultas(FakultasDto $requst);
    public function updateFakultas(string $faculty, FakultasDto $request);
    public function deleteFakultas(string $faculty);
}
