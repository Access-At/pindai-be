<?php

namespace Modules\Keuangan\Repositories;

use App\Models\Penelitian;
use App\Enums\StatusPenelitian;
use Modules\Keuangan\Exceptions\PenelitianException;

class PenelitianRepository
{
    public static function getAllPenelitian()
    {
        return Penelitian::query();
    }

    public static function getPenelitianById($id)
    {
        return Penelitian::with(['detail.anggotaPenelitian', 'kriteria', 'kriteria.luaran'])
            ->byHash($id)->first();
    }

    public static function approvedPenelitian(string $id)
    {
        $penelitian = Penelitian::byHash($id);

        if ( ! $penelitian) {
            throw PenelitianException::penelitianNotFound();
        }

        if (
            $penelitian->status_kaprodi === StatusPenelitian::Pending ||
            $penelitian->status_dppm === StatusPenelitian::Pending
        ) {
            throw PenelitianException::penelitianCantApproved('Penelitian ' . StatusPenelitian::Pending->message() . ' kaprodi dan dppm.');
        }

        if (
            $penelitian->status_keuangan->value === StatusPenelitian::Approval->value ||
            $penelitian->status_keuangan->value === StatusPenelitian::Reject->value
        ) {
            throw PenelitianException::penelitianCantApproved("Penelitian {$penelitian->status_dppm->message()}.");
        }

        $penelitian->update([
            'status_keuangan' => StatusPenelitian::Approval,
        ]);

        return self::getPenelitianById($id);
    }

    public static function canceledPenelitian(string $keterangan, string $id)
    {
        $penelitian = Penelitian::byHash($id);

        if ( ! $penelitian) {
            throw PenelitianException::penelitianNotFound();
        }

        if (
            $penelitian->status_kaprodi === StatusPenelitian::Pending ||
            $penelitian->status_dppm === StatusPenelitian::Pending
        ) {
            throw PenelitianException::penelitianCantApproved('Penelitian ' . StatusPenelitian::Pending->message() . ' kaprodi dan dppm.');
        }

        if (
            $penelitian->status_keuangan->value === StatusPenelitian::Approval->value ||
            $penelitian->status_keuangan->value === StatusPenelitian::Reject->value
        ) {
            throw PenelitianException::penelitianCantApproved("Penelitian {$penelitian->status_dppm->message()}.");
        }

        $penelitian->update([
            'status_keuangan' => StatusPenelitian::Reject,
            'keterangan' => $keterangan,
        ]);

        return self::getPenelitianById($id);
    }
}
