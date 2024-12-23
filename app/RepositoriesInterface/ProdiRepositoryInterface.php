<?php

namespace App\RepositoriesInterface;

use App\Models\Prodi;

interface ProdiRepositoryInterface
{
    public static function getAllProdi(int $perPage, int $page, string $search);
    public static function getListProdi($fakultas);
    public static function getProdiById(Prodi $id);
    public static function createProdi(array $data);
    public static function updateProdi(Prodi $id, array $data);
    public static function deleteProdi(Prodi $id);
}
