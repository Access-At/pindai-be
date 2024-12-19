<?php

namespace App\Repositories;

use App\Models\Faculty;
use App\RepositoriesInterface\FakultasRepositoryInterface;

class FakultasRepository implements FakultasRepositoryInterface
{
    public static function getAllFakultas($perPage, $page, $search)
    {
        return Faculty::where('name', 'like', '%' . $search . '%')
            ->orderBy('name', 'asc')
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public static function getFakultasById($id)
    {
        return Faculty::byHash($id);
    }

    public static function createFakultas($data)
    {
        return Faculty::create($data);
    }

    public static function updateFakultas($id, $data)
    {
        $fakultas = Faculty::byHash($id);
        $fakultas->update($data);
        return $fakultas;
    }

    public static function deleteFakultas($id)
    {
        $fakultas = Faculty::byHash($id);
        $fakultas->delete();
        return $fakultas;
    }

    public static function getNumberOfLecturersByFaculty()
    {
        return Faculty::withCount('dosen')
            ->orderBy('dosen_count', 'desc')
            ->take(8)
            ->get()
            ->map(function ($fakultas) {
                return [
                    'name' => $fakultas->name,
                    'dosen_count' => $fakultas->dosen_count,
                ];
            });
    }
}
