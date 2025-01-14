<?php

namespace Modules\Kaprodi\Interfaces;

use Modules\Kaprodi\DataTransferObjects\DosenDto;

interface DosenServiceInterface
{
    public function getAllDosen(array $options);
    public function getDosenById(string $id);
    public function insertDosen(DosenDto $request);
    public function updateDosen(string $id, DosenDto $request);
    public function deleteDosen(string $id);
    public function approvedDosen(string $id);
    public function activeDosen(string $id, bool $request);
}
