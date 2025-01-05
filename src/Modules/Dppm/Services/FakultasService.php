<?php

namespace Modules\Dppm\Services;

use App\Models\Faculty;
use Modules\Dppm\DataTransferObjects\FakultasDto;
use Modules\Dppm\Exceptions\FakultasException;
use Modules\Dppm\Interfaces\FakultasServiceInterface;
use Modules\Dppm\Repositories\FakultasRepository;
use Modules\Dppm\Resources\FakultasResource;
use Modules\Dppm\Resources\Pagination\FakultasPaginationCollection;

class FakultasService implements FakultasServiceInterface
{
    public function getAllFakultas(int $perPage, int $page, string $search)
    {
        return new FakultasPaginationCollection(FakultasRepository::getAllFakultas($perPage, $page, $search));
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

        if (!$fakultas) {
            throw FakultasException::fakultasNotFound();
        }
    }
}
