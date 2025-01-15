<?php

namespace Modules\Dppm\Services;

use App\Helper\PaginateHelper;
use Modules\Dppm\Resources\DosenResource;
use Modules\Dppm\Exceptions\DosenException;
use Modules\Dppm\Repositories\DosenRepository;
use Modules\Dppm\Interfaces\DosenServiceInterface;
use Modules\Dppm\Resources\Pagination\DosenPaginationCollection;

class DosenService implements DosenServiceInterface
{
    public function getAllDosen(array $options)
    {
        $data = PaginateHelper::paginate(
            DosenRepository::getAllDosen(),
            $options,
        );

        return new DosenPaginationCollection($data);
    }

    public function getDosenById(string $id)
    {
        $user = DosenRepository::getDosenById($id);

        if ( ! $user) {
            throw DosenException::dosenNotFound();
        }

        return new DosenResource($user);
    }
}
