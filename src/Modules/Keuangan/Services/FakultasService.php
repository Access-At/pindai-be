<?php

namespace Modules\Keuangan\Services;

use App\Helper\PaginateHelper;
use Modules\Keuangan\Resources\FakultasResource;
use Modules\Keuangan\Exceptions\FakultasException;
use Modules\Keuangan\DataTransferObjects\FakultasDto;
use Modules\Keuangan\Repositories\FakultasRepository;
use Modules\Keuangan\Interfaces\FakultasServiceInterface;
use Modules\Keuangan\Resources\Pagination\FakultasPaginationCollection;

class FakultasService implements FakultasServiceInterface
{
    public function getAllFakultas(array $options)
    {
        $data = PaginateHelper::paginate(
            FakultasRepository::getAllFakultas(),
            $options,
        );

        return new FakultasPaginationCollection($data);
    }

    public function getFakultasById(string $id)
    {
        $data = FakultasRepository::getFakultasById($id);
        $this->validateFakultasExists($id);

        return new FakultasResource($data);
    }

    public function insertFakultas(FakultasDto $requst)
    {
        return new FakultasResource(FakultasRepository::insertFakultas($requst));
    }

    public function updateFakultas(string $id, FakultasDto $request)
    {
        $this->validateFakultasExists($id);

        return new FakultasResource(FakultasRepository::updateFakultas($id, $request));
    }

    public function deleteFakultas(string $id)
    {
        $this->validateFakultasExists($id);

        return new FakultasResource(FakultasRepository::deleteFakultas($id));
    }

    private function validateFakultasExists(string $id): void
    {
        $fakultas = FakultasRepository::getFakultasById($id);

        if ( ! $fakultas) {
            throw FakultasException::fakultasNotFound();
        }
    }
}
