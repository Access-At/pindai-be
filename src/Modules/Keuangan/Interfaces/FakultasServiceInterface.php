<?php

namespace Modules\Keuangan\Interfaces;

use Modules\Keuangan\DataTransferObjects\FakultasDto;

interface FakultasServiceInterface
{
    public function getAllFakultas(array $options);

    public function getFakultasById(string $id);

    public function insertFakultas(FakultasDto $requst);

    public function updateFakultas(string $faculty, FakultasDto $request);

    public function deleteFakultas(string $faculty);
}
