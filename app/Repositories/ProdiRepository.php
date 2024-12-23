<?php

namespace App\Repositories;

use App\Models\Faculty;
use App\Models\Prodi;
use App\RepositoriesInterface\ProdiRepositoryInterface;

class ProdiRepository implements ProdiRepositoryInterface
{
    public static function getListProdi($fakultas)
    {
        $dataFakultas = Faculty::byHash($fakultas);
        return Prodi::where('faculties_id', $dataFakultas->id)->get();
    }

    public static function getAllProdi(int $perPage, int $page, string $search)
    {
        return Prodi::with(['faculty' => function ($q) {
            $q->select('id', 'name');
        }])->where('name', 'like', '%' . $search . '%')
            ->orderBy('name', 'asc')
            ->paginate($perPage, ['*'], 'page', $page);
    }

    public static function getProdiById($id)
    {
        return Prodi::byHash($id);
    }

    public static function createProdi($data)
    {
        return Prodi::create($data);
    }

    public static function updateProdi($id, $data)
    {
        $prodi = Prodi::byHash($id);
        $prodi->update($data);
        return $prodi;
    }

    public static function deleteProdi($id)
    {
        $prodi = Prodi::byHash($id);
        $prodi->delete();
        return $prodi;
    }
}
