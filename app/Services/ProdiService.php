<?php

namespace App\Services;

use App\Http\Resources\Kaprodi\ProdiResource;
use App\Repositories\ProdiRepository;

class ProdiService
{

    public static function getAllProdi(int $perPage, int $page, string $search)
    {
        return ProdiRepository::getAllProdi($perPage, $page, $search);
    }

    public static function getListProdi($fakultas)
    {
        return ProdiResource::collection(ProdiRepository::getListProdi($fakultas));
    }

    public static function getProdiById($id)
    {
        return new ProdiResource(ProdiRepository::getProdiById($id));
    }

    public static function createProdi($data)
    {
        return new ProdiResource(ProdiRepository::createProdi($data));
    }

    public static function updateProdi($id, $data)
    {
        return new ProdiResource(ProdiRepository::updateProdi($id, $data));
    }

    public static function deleteProdi($id)
    {
        return new ProdiResource(ProdiRepository::deleteProdi($id));
    }
}
