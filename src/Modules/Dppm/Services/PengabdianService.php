<?php

namespace Modules\Dppm\Services;

use App\Helper\PaginateHelper;
use Modules\Dppm\DataTransferObjects\PengabdianDto;
use Modules\Dppm\Exceptions\PengabdianException;
use Modules\Dppm\Repositories\PengabdianRepository;
use Modules\Dppm\Resources\DetailPengabdianResource;
use Modules\Dppm\Interfaces\PengabdianServiceInterface;
use Modules\Dppm\Resources\Pagination\PengabdianPaginationCollection;

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
        $pengabdian = PengabdianRepository::getPengabdianById($id);

        if (! $pengabdian) {
            throw PengabdianException::pengabdianNotFound();
        }

        return new DetailPengabdianResource($pengabdian);
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
