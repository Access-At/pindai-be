<?php

namespace App\RepositoriesInterface;

use App\Models\Kaprodi;

interface KaprodiRepositoryInterface
{
    public static function getAllKaprodi(int $perPage, int $page, string $search);

    public static function getKaprodiById(Kaprodi $id);

    public static function createKaprodi(array $data);

    public static function updateKaprodi(Kaprodi $id, array $data);

    public static function deleteKaprodi(Kaprodi $id);
}
