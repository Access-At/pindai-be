<?php

namespace Modules\Dosen\Repositories;

use App\Models\Penelitian;
use Modules\Dosen\DataTransferObjects\PenelitianDto;

class PenelitianRepository
{
    public static function getAllPenelitian($perPage, $page, $search)
    {
        return Penelitian::paginate($perPage, ['*'], 'page', $page);
    }

    public static function getPenelitianById($id)
    {
        // TODO: Implement getPenelitianById() method.
    }

    public static function insertPenelitian(PenelitianDto $request)
    {
        // TODO: Implement insertPenelitian() method.
    }

    public static function updatePenelitian($id, PenelitianDto $request)
    {
        // TODO: Implement updatePenelitian() method.
    }
}
