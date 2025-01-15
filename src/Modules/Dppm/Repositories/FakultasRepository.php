<?php

namespace Modules\Dppm\Repositories;

use App\Models\Faculty;
use Modules\Dppm\DataTransferObjects\FakultasDto;

class FakultasRepository
{
    public static function getAllFakultas()
    {
        return Faculty::query();
    }

    public static function getFakultasById(string $id)
    {
        return Faculty::byHash($id);
    }

    public static function insertFakultas(FakultasDto $data)
    {
        return Faculty::create([
            'name' => $data->name,
        ]);
    }

    public static function updateFakultas(string $id, FakultasDto $data)
    {
        $fakultas = Faculty::byHash($id);
        $fakultas->update([
            'name' => $data->name,
        ]);

        return $fakultas;
    }

    public static function deleteFakultas(string $id)
    {
        $fakultas = Faculty::byHash($id);
        $fakultas->delete();

        return $fakultas;
    }
}
