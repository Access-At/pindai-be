<?php

namespace App\RepositoriesInterface;

interface DosenRepositoryInterface
{
    public static function getAllDosen($perPage, $page, $search);
    public static function getDosenById($id);
    public static function createDosen($data);
    public static function updateDosen($id, $data);
    public static function deleteDosen($id);
}
