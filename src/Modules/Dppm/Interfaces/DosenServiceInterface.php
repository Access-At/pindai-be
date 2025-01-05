<?php

namespace Modules\Dppm\Interfaces;


interface DosenServiceInterface
{
    public function getAllDosen(int $perPage, int $page, string $search);
    public function getDosenById(string $id);
}
