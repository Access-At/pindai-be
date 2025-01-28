<?php

namespace Modules\Kaprodi\Services;

use App\Helper\PaginateHelper;
use Modules\Kaprodi\Exceptions\PublikasiException;
use Modules\Kaprodi\DataTransferObjects\PublikasiDto;
use Modules\Kaprodi\Repositories\PublikasiRepository;
use Modules\Kaprodi\Resources\DetailPublikasiResource;
use Modules\Kaprodi\Interfaces\PublikasiServiceInterface;
use Modules\Kaprodi\Resources\Pagination\PublikasiPaginationCollection;

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
