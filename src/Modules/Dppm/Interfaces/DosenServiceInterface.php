<?php

namespace Modules\Dppm\Interfaces;


interface DosenServiceInterface
{
    public function getAllDosen(array $options);
    public function getDosenById(string $id);
}
