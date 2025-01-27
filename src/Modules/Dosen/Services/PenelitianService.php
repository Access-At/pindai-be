<?php

namespace Modules\Dosen\Services;

use App\Enums\StatusPenelitian;
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
        $dosen = User::dosenRole()
            ->where('id', $user->id)
            ->with('dosen.prodi', 'dosen.fakultas')
            ->first();

        $userLogin = new DosenResource($dosen);

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

    public function deletePenelitian(string $id)
    {
        $this->validatePenelitianExists($id);

        return new PenelitianResource(PenelitianRepository::deletePenelitian($id));
    }

    private function validatePenelitianExists(string $id): void
    {
        $penelitian = PenelitianRepository::getPenelitianById($id);

        if (! $penelitian) {
            throw PenelitianException::penelitianNotFound();
        }

        if (
            $penelitian->status_dppm === StatusPenelitian::Approval &&
            $penelitian->status_kaprodi === StatusPenelitian::Approval
        ) {
            throw PenelitianException::penelitianNotDelete();
        }
    }
}
