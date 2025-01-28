<?php

namespace Modules\Kaprodi\Repositories;

use App\Models\User;
use App\Models\Prodi;
use App\Models\Pengabdian;
use App\Enums\StatusPenelitian;
use Modules\Kaprodi\Exceptions\PengabdianException;

class PengabdianRepository
{
    public static function getAllPengabdian()
    {
        $user = auth('api')->user();

        $userLogin = User::where('id', $user->id)
            ->with('kaprodi.faculty')
            ->first();

        $prodi = Prodi::where('faculties_id', $userLogin->kaprodi->faculty->id)
            ->get()
            ->pluck('name');

        return Pengabdian::ProdiPengabdian(
            $prodi
        );
    }

    public static function getPengabdianById($id)
    {
        return Pengabdian::with(['kriteria', 'kriteria.luaran', 'detail.anggotaPengabdian'])
            ->byHash($id)->first();
    }

    public static function approvedPengabdian(string $id)
    {
        $pengabdian = Pengabdian::byHash($id);

        if ( ! $pengabdian) {
            throw PengabdianException::pengabdianNotFound();
        }

        if (
            $pengabdian->status_kaprodi->value === StatusPenelitian::Approval->value ||
            $pengabdian->status_kaprodi->value === StatusPenelitian::Reject->value
        ) {
            throw PengabdianException::pengabdianCantApproved($pengabdian->status_kaprodi->name);
        }

        $pengabdian->update([
            'status_kaprodi' => StatusPenelitian::Approval,
        ]);

        return self::getPengabdianById($id);
    }

    public static function canceledPengabdian(string $keterangan, string $id)
    {
        $pengabdian = Pengabdian::byHash($id);

        if ( ! $pengabdian) {
            throw PengabdianException::pengabdianNotFound();
        }

        if (
            $pengabdian->status_kaprodi->value === StatusPenelitian::Approval->value ||
            $pengabdian->status_kaprodi->value === StatusPenelitian::Reject->value
        ) {
            throw PengabdianException::pengabdianCantCanceled($pengabdian->status_kaprodi->name);
        }

        $pengabdian->update([
            'status_kaprodi' => StatusPenelitian::Reject,
            'status_dppm' => StatusPenelitian::Reject,
            'status_keuangan' => StatusPenelitian::Reject,
            'keterangan' => $keterangan,
        ]);

        return self::getPengabdianById($id);
    }
}
