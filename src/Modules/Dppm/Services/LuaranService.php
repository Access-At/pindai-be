<?php

namespace Modules\Dppm\Services;

use App\Helper\PaginateHelper;
use Modules\Dppm\Resources\LuaranResource;
use Modules\Dppm\Exceptions\LuaranException;
use Modules\Dppm\DataTransferObjects\LuaranDto;
use Modules\Dppm\Repositories\LuaranRepository;
use Modules\Dppm\Interfaces\LuaranServiceInterface;
use Modules\Dppm\Resources\DetailLuaranResource;
use Modules\Dppm\Resources\Pagination\LuaranPaginationCollection;

class LuaranService implements LuaranServiceInterface
{
    public function getAllLuaran(array $options)
    {
        $data = PaginateHelper::paginate(
            LuaranRepository::getAllLuaran(),
            $options,
        );

        return new LuaranPaginationCollection($data);
    }

    public function getLuaranById(string $id)
    {
        $data = LuaranRepository::getLuaranById($id);
        $this->validateLuaranExists($id);

        return new DetailLuaranResource($data);
    }

    public function insertLuaran(LuaranDto $requst)
    {
        return new LuaranResource(LuaranRepository::insertLuaran($requst));
    }

    public function updateLuaran(string $id, LuaranDto $request)
    {
        $this->validateLuaranExists($id);

        return new LuaranResource(LuaranRepository::updateLuaran($id, $request));
    }

    public function deleteLuaran(string $id)
    {
        $this->validateLuaranExists($id);

        return new LuaranResource(LuaranRepository::deleteLuaran($id));
    }

    private function validateLuaranExists(string $id): void
    {
        $Luaran = LuaranRepository::getLuaranById($id);

        if (! $Luaran) {
            throw LuaranException::LuaranNotFound();
        }
    }
}
