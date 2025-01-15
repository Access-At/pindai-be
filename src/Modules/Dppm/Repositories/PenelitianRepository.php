<?php

namespace Modules\Dppm\Repositories;

use App\Models\Penelitian;
use App\Enums\StatusPenelitian;
use Modules\Dppm\Exceptions\PenelitianException;

class PenelitianRepository
{
    public static function getAllPenelitian()
    {
        // $user = auth('api')->user();

        // $userLogin = User::where('id', $user->id)
        //     ->with('kaprodi.faculty')
        //     ->first();

        // $prodi = Prodi::where('faculties_id', $userLogin->kaprodi->faculty->id)
        //     ->get()
        //     ->pluck('name');

        return Penelitian::query();
    }

    public static function getPenelitianById($id)
    {
        return Penelitian::with(['jenisPenelitian', 'jenisIndex', 'detail.anggotaPenelitian'])
            ->byHash($id)
            ->first();
    }

    public static function approvedPenelitian(string $id)
    {
        $penelitian = Penelitian::byHash($id);

        if (! $penelitian) {
            throw PenelitianException::penelitianNotFound();
        }

        if ($penelitian->status_kaprodi === StatusPenelitian::Pending) {
            throw PenelitianException::penelitianCantApproved(
                "Menunggu persetujuan kaprodi."
            );
        }

        if (
            $penelitian->status_dppm->value === StatusPenelitian::Approval->value ||
            $penelitian->status_dppm->value === StatusPenelitian::Reject->value
        ) {
            throw PenelitianException::penelitianCantApproved("penelitian sudah {$penelitian->status_dppm->name}.");
        }

        $penelitian->update([
            'status_dppm' => StatusPenelitian::Approval,
        ]);

        return self::getPenelitianById($id);
    }

    public static function canceledPenelitian(string $keterangan, string $id)
    {
        $penelitian = Penelitian::byHash($id);

        if (! $penelitian) {
            throw PenelitianException::penelitianNotFound();
        }

        if ($penelitian->status_kaprodi === StatusPenelitian::Pending) {
            throw PenelitianException::penelitianCantCanceled(
                "Menunggu persetujuan kaprodi."
            );
        }

        if (
            $penelitian->status_dppm->value === StatusPenelitian::Approval->value ||
            $penelitian->status_dppm->value === StatusPenelitian::Reject->value
        ) {
            throw PenelitianException::penelitianCantCanceled("penelitian sudah {$penelitian->status_dppm->name}.");
        }

        $penelitian->update([
            'status_dppm' => StatusPenelitian::Reject,
            'status_keuangan' => StatusPenelitian::Reject,
            'keterangan' => $keterangan,
        ]);

        return self::getPenelitianById($id);
    }
}
