<?php

namespace Modules\Kaprodi\Repositories;

use App\Models\User;
use App\Models\Prodi;
use App\Models\Penelitian;
use App\Enums\StatusPenelitian;
use Modules\Kaprodi\Exceptions\PenelitianException;
use Modules\Kaprodi\DataTransferObjects\PenelitianDto;

class PenelitianRepository
{
    public static function getAllPenelitian()
    {
        $user = auth('api')->user();

        $userLogin = User::where('id', $user->id)
            ->with('kaprodi.faculty')
            ->first();

        $prodi = Prodi::where('faculties_id', $userLogin->kaprodi->faculty->id)
            ->get()
            ->pluck('name');

        return Penelitian::ProdiPenelitian(
            $prodi
        );
    }

    public static function getPenelitianById($id)
    {
        return Penelitian::with(['detail.anggotaPenelitian', 'kriteria', 'kriteria.luaran'])
            ->byHash($id)->first();
    }

    public static function approvedPenelitian(string $id)
    {
        $penelitian = Penelitian::byHash($id);

        if (! $penelitian) {
            throw PenelitianException::penelitianNotFound();
        }

        if (
            $penelitian->status_kaprodi->value === StatusPenelitian::Approval->value ||
            $penelitian->status_kaprodi->value === StatusPenelitian::Reject->value
        ) {
            throw PenelitianException::penelitianCantApproved($penelitian->status_kaprodi->name);
        }

        $penelitian->update([
            'status_kaprodi' => StatusPenelitian::Approval,
        ]);

        return self::getPenelitianById($id);
    }

    public static function canceledPenelitian(string $keterangan, string $id)
    {
        $penelitian = Penelitian::byHash($id);

        if (! $penelitian) {
            throw PenelitianException::penelitianNotFound();
        }

        if (
            $penelitian->status_kaprodi->value === StatusPenelitian::Approval->value ||
            $penelitian->status_kaprodi->value === StatusPenelitian::Reject->value
        ) {
            throw PenelitianException::penelitianCantCanceled($penelitian->status_kaprodi->name);
        }

        $penelitian->update([
            'status_kaprodi' => StatusPenelitian::Reject,
            'status_dppm' => StatusPenelitian::Reject,
            'status_keuangan' => StatusPenelitian::Reject,
            'keterangan' => $keterangan,
        ]);

        return self::getPenelitianById($id);
    }
}
