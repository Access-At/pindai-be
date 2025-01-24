<?php

namespace Modules\Keuangan\Services;

use App\Helper\PaginateHelper;
use Modules\Keuangan\DataTransferObjects\PengabdianDto;
use Modules\Keuangan\Exceptions\PengabdianException;
use Modules\Keuangan\Repositories\PengabdianRepository;
use Modules\Keuangan\Resources\DetailPengabdianResource;
use Modules\Keuangan\Interfaces\PengabdianServiceInterface;
use Modules\Keuangan\Resources\Pagination\PengabdianPaginationCollection;

class PengabdianService implements PengabdianServiceInterface
{
    public function getAllPengabdian(array $options)
    {
        $data = PaginateHelper::paginate(
            PengabdianRepository::getAllPengabdian(),
            $options,
        );

        return new PengabdianPaginationCollection($data);
    }

    public function getPengabdianById(string $id)
    {
        $penelitian = PengabdianRepository::getPengabdianById($id);

        if (! $penelitian) {
            throw PengabdianException::penelitianNotFound();
        }

        return new DetailPengabdianResource($penelitian);
    }

    public function approvedPengabdian(string $id)
    {
        return new DetailPengabdianResource(PengabdianRepository::approvedPengabdian($id));
    }

    public function canceledPengabdian(PengabdianDto $request, string $id)
    {
        return new DetailPengabdianResource(PengabdianRepository::canceledPengabdian($request->keterangan, $id));
    }

    // public function insertPengabdian(PengabdianDto $request) {}
    // public function updatePengabdian(string $id, PengabdianDto $request) {}
    // public function deletePengabdian(string $id) {}
}
