<?php

namespace App\Services;

use App\Repositories\FakultasRepository;
use App\Http\Resources\Dppm\FakultasResource;
use App\Http\Resources\Pagination\FakultasPaginationCollection;

class FakultasService
{
    public static function getAllFakultas($perPage, $page, $search)
    {
        return new FakultasPaginationCollection(FakultasRepository::getAllFakultas($perPage, $page, $search));
    }

    public static function getListFakultas()
    {
        return FakultasResource::collection(FakultasRepository::getListFakultas());
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
