<?php

namespace App\Services;

use App\Http\Resources\Dppm\KaprodiResource;
use App\Http\Resources\Pagination\KaprodiPaginationCollection;
use App\Repositories\KaprodiRepository;

class KaprodiService
{

    public static function getAllKaprodi($perPage, $page, $search)
    {
        $data = KaprodiRepository::getAllKaprodi($perPage, $page, $search);
        return new KaprodiPaginationCollection($data);
    }

    public static function getKaprodiById($id)
    {
        return new KaprodiResource(KaprodiRepository::getKaprodiById($id));
    }

    public static function createKaprodi($data)
    {
        // TODO: password masih hardcode, harusnya random, harusnya ada middleware untuk mengirimkan email ke user
        $password = 'password';

        $data['password'] = bcrypt($password);
        return new KaprodiResource(KaprodiRepository::createKaprodi($data));
    }

    public static function updateKaprodi($id, $data)
    {
        return new KaprodiResource(KaprodiRepository::updateKaprodi($id, $data));
    }

    public static function deleteKaprodi($id)
    {
        return new KaprodiResource(KaprodiRepository::deleteKaprodi($id));
    }
}
