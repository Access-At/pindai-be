<?php

namespace App\RepositoriesInterface;

use App\Models\Faculty;

interface FakultasRepositoryInterface
{
    public static function getAllFakultas(int $perPage, int $page, string $search);
    public static function getFakultasById(Faculty $id);
    public static function createFakultas(array $data);
    public static function updateFakultas(Faculty $id, array $data);
    public static function deleteFakultas(Faculty $id);
}
