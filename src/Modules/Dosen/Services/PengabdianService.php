<?php

namespace Modules\Dosen\Services;

use App\Enums\StatusPenelitian;
use App\Models\User;
use App\Helper\PaginateHelper;
use Modules\Dosen\Resources\DosenResource;
use Modules\Dosen\Resources\PengabdianResource;
use Modules\Dosen\DataTransferObjects\PengabdianDto;
use Modules\Dosen\Exceptions\PengabdianException;
use Modules\Dosen\Repositories\PengabdianRepository;
use Modules\Dosen\Resources\DetailPengabdianResource;
use Modules\Dosen\Interfaces\PengabdianServiceInterface;
use Modules\Dosen\Resources\Pagination\PengabdianPaginationCollection;

class PengabdianService implements PengabdianServiceInterface
{
    public function getAllPengabdian(array $options)
    {
        $data = PaginateHelper::paginate(
            PengabdianRepository::getAllPengabdian(),
            $options,
        );

        return new PengabdianPaginationCollection($data);
    }

    public function getPengabdianById(string $id)
    {
        $Pengabdian = PengabdianRepository::getPengabdianById($id);

        if (!$Pengabdian) {
            throw PengabdianException::PengabdianNotFound();
        }

        return new DetailPengabdianResource($Pengabdian);
    }

    public function insertPengabdian(PengabdianDto $request)
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

        return new PengabdianResource(PengabdianRepository::insertPengabdian($request));
    }

    public function updatePengabdian(string $id, PengabdianDto $request)
    {
        // TODO: Implement updatePengabdian() method.
    }

    public function deletePengabdian(string $id)
    {
        $this->validatePengabdianExists($id);

        return new PengabdianResource(PengabdianRepository::deletePengabdian($id));
    }

    private function validatePengabdianExists(string $id): void
    {
        $pengabdian = PengabdianRepository::getPengabdianById($id);

        if (!$pengabdian) {
            throw PengabdianException::PengabdianNotFound();
        }

        if (
            $pengabdian->status_dppm === StatusPenelitian::Approval &&
            $pengabdian->status_kaprodi === StatusPenelitian::Approval
        ) {
            throw PengabdianException::PengabdianNotDelete();
        }
    }
}
