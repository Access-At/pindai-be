<?php

namespace Modules\Dosen\Services;

use App\Models\User;
use Modules\Dosen\DataTransferObjects\PenelitianDto;
use Modules\Dosen\Interfaces\PenelitianServiceInterface;
use Modules\Dosen\Repositories\PenelitianRepository;
use Modules\Dosen\Resources\DetailPenelitianResource;
use Modules\Dosen\Resources\DosenResource;
use Modules\Dosen\Resources\Pagination\PenelitianPaginationCollection;
use Modules\Dosen\Resources\PenelitianResource;

class PenelitianService implements PenelitianServiceInterface
{
    public function getAllPenelitian(int $perPage, int $page, string $search)
    {
        return new PenelitianPaginationCollection(PenelitianRepository::getAllPenelitian($perPage, $page, $search));
    }

    public function getPenelitianById(string $id)
    {
        return new DetailPenelitianResource(PenelitianRepository::getPenelitianById($id));
    }

    public function insertPenelitian(PenelitianDto $request)
    {
        $user = auth('api')->user();

        $userLogin = new DosenResource(
            User::where('id', $user->id)
                ->with('dosen.prodi', 'dosen.fakultas')
                ->first()
        );

        // ubah menjadi array
        $anggota = $userLogin->resolve();

        // Ensure $anggota and $request->anggota are arrays
        $anggota = is_array($anggota) ? [$anggota] : [];
        $requestAnggota = is_array($request->anggota) ? $request->anggota : [];

        // Merge the arrays
        $request->anggota = array_merge($anggota, $requestAnggota);

        return new PenelitianResource(PenelitianRepository::insertPenelitian($request));
    }

    public function updatePenelitian(string $id, PenelitianDto $request)
    {
        // TODO: Implement updatePenelitian() method.
    }
}
