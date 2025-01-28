<?php

namespace Modules\Keuangan\Services;

use App\Helper\PaginateHelper;
use Modules\Keuangan\Exceptions\PublikasiException;
use Modules\Keuangan\DataTransferObjects\PublikasiDto;
use Modules\Keuangan\Repositories\PublikasiRepository;
use Modules\Keuangan\Resources\DetailPublikasiResource;
use Modules\Keuangan\Interfaces\PublikasiServiceInterface;
use Modules\Keuangan\Resources\Pagination\PublikasiPaginationCollection;

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
