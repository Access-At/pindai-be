<?php

namespace App\Services;

use App\Http\Resources\FakultasPaginationResource;
use App\Http\Resources\FakultasResource;
use App\Repositories\FakultasRepository;

class FakultasService
{
    public static function getAllFakultas($perPage, $page, $search)
    {
        return new FakultasPaginationResource(FakultasRepository::getAllFakultas($perPage, $page, $search));
    }

    public static function getFakultasById($id)
    {
        return new FakultasResource(FakultasRepository::getFakultasById($id));
    }

    public static function createFakultas($data)
    {
        return new FakultasResource(FakultasRepository::createFakultas($data));
    }

    public static function updateFakultas($id, $data)
    {
        return new FakultasResource(FakultasRepository::updateFakultas($id, $data));
    }

    public static function deleteFakultas($id)
    {
        return new FakultasResource(FakultasRepository::deleteFakultas($id));
    }
}
