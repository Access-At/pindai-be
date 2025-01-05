<?php

namespace Modules\Dosen\Services;

use App\Models\User;
use Modules\Dosen\DataTransferObjects\PenelitianDto;
use Modules\Dosen\Interfaces\PenelitianServiceInterface;
use Modules\Dosen\Repositories\PenelitianRepository;
use Modules\Dosen\Resources\Pagination\PenelitianPaginationCollection;
use Modules\Dppm\Resources\DosenResource;

class PenelitianService implements PenelitianServiceInterface
{
    public function getAllPenelitian(int $perPage, int $page, string $search)
    {
        return new PenelitianPaginationCollection(PenelitianRepository::getAllPenelitian($perPage, $page, $search));
    }

    public function getPenelitianById(string $id)
    {
        // TODO: Implement getPenelitianById() method.
    }

    public function insertPenelitian(PenelitianDto $request)
    {
        // TODO: Implement insertPenelitian() method.
        $user = auth('api')->user();

        $userLogin = new DosenResource(User::where('id', $user->id)
            ->with('dosen.prodi', 'dosen.fakultas')
            ->first());

        dd($userLogin->resolve());

        dd($user);
    }

    public function updatePenelitian(string $id, PenelitianDto $request)
    {
        // TODO: Implement updatePenelitian() method.
    }
}
