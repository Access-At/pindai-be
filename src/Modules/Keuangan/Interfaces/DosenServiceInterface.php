<?php

namespace Modules\Keuangan\Interfaces;

interface DosenServiceInterface
{
    public function getAllDosen(array $options);

    public function getDosenById(string $id);
}
