<?php

namespace Modules\Keuangan\Services;

use App\Helper\PaginateHelper;
use Modules\Keuangan\Resources\DosenResource;
use Modules\Keuangan\Exceptions\DosenException;
use Modules\Keuangan\Repositories\DosenRepository;
use Modules\Keuangan\Interfaces\DosenServiceInterface;
use Modules\Keuangan\Resources\Pagination\DosenPaginationCollection;

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
