<?php

namespace Modules\Kaprodi\Services;

use App\Helper\PaginateHelper;
use Modules\Kaprodi\Exceptions\PenelitianException;
use Modules\Kaprodi\Interfaces\PenelitianServiceInterface;
use Modules\Kaprodi\Repositories\PenelitianRepository;
use Modules\Kaprodi\Resources\DetailPenelitianResource;
use Modules\Kaprodi\Resources\Pagination\PenelitianPaginationCollection;

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

        if (!$penelitian) {
            throw PenelitianException::penelitianNotFound();
        }

        return new DetailPenelitianResource($penelitian);
    }

    public function approvedPenelitian(string $id)
    {
        return new DetailPenelitianResource(PenelitianRepository::approvedPenelitian($id));
    }

    public function canceledPenelitian(string $id)
    {
        return new DetailPenelitianResource(PenelitianRepository::canceledPenelitian($id));
    }

    // public function insertPenelitian(PenelitianDto $request) {}
    // public function updatePenelitian(string $id, PenelitianDto $request) {}
    // public function deletePenelitian(string $id) {}
}
