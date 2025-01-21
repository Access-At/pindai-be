<?php

namespace Modules\Keuangan\Services;

use App\Helper\PaginateHelper;
use Modules\Keuangan\DataTransferObjects\PenelitianDto;
use Modules\Keuangan\Exceptions\PenelitianException;
use Modules\Keuangan\Repositories\PenelitianRepository;
use Modules\Keuangan\Resources\DetailPenelitianResource;
use Modules\Keuangan\Interfaces\PenelitianServiceInterface;
use Modules\Keuangan\Resources\Pagination\PenelitianPaginationCollection;

class PenelitianService implements PenelitianServiceInterface
{
    public function getAllPenelitian(array $options)
    {
        $data = PaginateHelper::paginate(
            PenelitianRepository::getAllPenelitian(),
            $options,
        );

        return new PenelitianPaginationCollection($data);
    }

    public function getPenelitianById(string $id)
    {
        $penelitian = PenelitianRepository::getPenelitianById($id);

        if (! $penelitian) {
            throw PenelitianException::penelitianNotFound();
        }

        return new DetailPenelitianResource($penelitian);
    }

    public function approvedPenelitian(string $id)
    {
        return new DetailPenelitianResource(PenelitianRepository::approvedPenelitian($id));
    }

    public function canceledPenelitian(PenelitianDto $request, string $id)
    {
        return new DetailPenelitianResource(PenelitianRepository::canceledPenelitian($request->keterangan, $id));
    }

    // public function insertPenelitian(PenelitianDto $request) {}
    // public function updatePenelitian(string $id, PenelitianDto $request) {}
    // public function deletePenelitian(string $id) {}
}
