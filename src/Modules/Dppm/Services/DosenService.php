<?php

namespace Modules\Dppm\Services;

use Modules\Dppm\Exceptions\DosenException;
use Modules\Dppm\Resources\Pagination\DosenPaginationCollection;
use Modules\Dppm\Interfaces\DosenServiceInterface;
use Modules\Dppm\Repositories\DosenRepository;
use Modules\Dppm\Resources\DosenResource;

class DosenService implements DosenServiceInterface
{
    public function getAllDosen(int $perPage, int $page, string $search)
    {
        return new DosenPaginationCollection(DosenRepository::getAllDosen($perPage, $page, $search));
    }

    public function getDosenById(string $id)
    {
        $user = DosenRepository::getDosenById($id);

        if (!$user) {
            throw DosenException::dosenNotFound();
        }

        return new DosenResource($user);
    }
}
