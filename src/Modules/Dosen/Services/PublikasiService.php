<?php

namespace Modules\Dosen\Services;

use App\Helper\PaginateHelper;
use App\Enums\StatusPenelitian;
use Modules\Dosen\Resources\PublikasiResource;
use Modules\Dosen\Exceptions\PublikasiException;
use Modules\Dosen\DataTransferObjects\PublikasiDto;
use Modules\Dosen\Repositories\PublikasiRepository;
use Modules\Dosen\Resources\DetailPublikasiResource;
use Modules\Dosen\Interfaces\PublikasiServiceInterface;
use Modules\Dosen\Resources\Pagination\PublikasiPaginationCollection;

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

    public function insertPublikasi(PublikasiDto $request)
    {
        return new PublikasiResource(PublikasiRepository::insertPublikasi($request));
    }

    public function updatePublikasi(string $id, PublikasiDto $request)
    {
        $this->validatePublikasiExists($id);

        return new PublikasiResource(PublikasiRepository::updatePublikasi($id, $request));
    }

    public function deletePublikasi(string $id)
    {
        $this->validatePublikasiExists($id);

        return new PublikasiResource(PublikasiRepository::deletePublikasi($id));
    }

    private function validatePublikasiExists(string $id): void
    {
        $publikasi = PublikasiRepository::getPublikasiById($id);

        if ( ! $publikasi) {
            throw PublikasiException::publikasiNotFound();
        }

        if (
            $publikasi->status_dppm === StatusPenelitian::Approval &&
            $publikasi->status_kaprodi === StatusPenelitian::Approval
        ) {
            throw PublikasiException::PublikasiNotDelete();
        }
    }
}
