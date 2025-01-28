<?php

namespace Modules\Dppm\Services;

use App\Helper\PaginateHelper;
use Modules\Dppm\Exceptions\PublikasiException;
use Modules\Dppm\DataTransferObjects\PublikasiDto;
use Modules\Dppm\Repositories\PublikasiRepository;
use Modules\Dppm\Resources\DetailPublikasiResource;
use Modules\Dppm\Interfaces\PublikasiServiceInterface;
use Modules\Dppm\Resources\Pagination\PublikasiPaginationCollection;

class PublikasiService implements PublikasiServiceInterface
{
    public function getAllPublikasi(array $options)
    {
        $data = PaginateHelper::paginate(
            PublikasiRepository::getAllPublikasi(),
            $options,
        );

        return new PublikasiPaginationCollection($data);
    }

    public function getPublikasiById(string $id)
    {
        $publikasi = PublikasiRepository::getPublikasiById($id);

        if ( ! $publikasi) {
            throw PublikasiException::publikasiNotFound();
        }

        return new DetailPublikasiResource($publikasi);
    }

    public function approvedPublikasi(string $id)
    {
        return new DetailPublikasiResource(PublikasiRepository::approvedPublikasi($id));
    }

    public function canceledPublikasi(PublikasiDto $request, string $id)
    {
        return new DetailPublikasiResource(PublikasiRepository::canceledPublikasi($request->keterangan, $id));
    }

    // public function insertPublikasi(PublikasiDto $request) {}
    // public function updatePublikasi(string $id, PublikasiDto $request) {}
    // public function deletePublikasi(string $id) {}
}
