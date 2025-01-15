<?php

namespace Modules\Dosen\Services;

use App\Models\User;
use App\Helper\PaginateHelper;
use Modules\Dosen\Resources\DosenResource;
use Modules\Dosen\Resources\PenelitianResource;
use Modules\Dosen\DataTransferObjects\PenelitianDto;
use Modules\Dosen\Exceptions\PenelitianException;
use Modules\Dosen\Repositories\PenelitianRepository;
use Modules\Dosen\Resources\DetailPenelitianResource;
use Modules\Dosen\Interfaces\PenelitianServiceInterface;
use Modules\Dosen\Resources\Pagination\PenelitianPaginationCollection;

class PenelitianService implements PenelitianServiceInterface
{
    public function getAllPenelitian(array $options)
    {
        $data = PaginateHelper::paginate(
            PenelitianRepository::getAllPenelitian(),
            $options,
        );

        return new PenelitianPaginationCollection($data);
    }

    public function getPenelitianById(string $id)
    {
        $penelitian = PenelitianRepository::getPenelitianById($id);

        if (!$penelitian) {
            throw PenelitianException::penelitianNotFound();
        }

        return new DetailPenelitianResource($penelitian);
    }

    public function insertPenelitian(PenelitianDto $request)
    {
        $user = auth('api')->user();

        $userLogin = new DosenResource(
            User::where('id', $user->id)
                ->with('dosen.prodi', 'dosen.fakultas')
                ->first()
        );

        // ubah menjadi array
        $anggota = $userLogin->resolve();

        // Ensure $anggota and $request->anggota are arrays
        $anggota = is_array($anggota) ? [$anggota] : [];

        // remove is_leader if found, SECURITY BYPASS
        array_walk($request->anggota, function (&$anggota) {
            unset($anggota['is_leader']);
        });

        $request->anggota = is_array($request->anggota) ? $request->anggota : [];

        // Merge the arrays
        $request->anggota = array_merge($anggota, $request->anggota);

        return new PenelitianResource(PenelitianRepository::insertPenelitian($request));
    }

    public function updatePenelitian(string $id, PenelitianDto $request)
    {
        // TODO: Implement updatePenelitian() method.
    }
}
