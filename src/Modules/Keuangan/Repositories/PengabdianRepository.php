<?php

namespace Modules\Keuangan\Repositories;

use App\Models\Pengabdian;
use App\Enums\StatusPenelitian;
use Modules\Keuangan\Exceptions\PengabdianException;

class PengabdianRepository
{
    public static function getAllPengabdian()
    {
        return Pengabdian::query();
    }

    public static function getPengabdianById($id)
    {
        return Pengabdian::with(['kriteria', 'kriteria.luaran', 'detail.anggotaPengabdian'])
            ->byHash($id)->first();
    }

    public static function approvedPengabdian(string $id)
    {
        $pengabdian = Pengabdian::byHash($id);

        if (! $pengabdian) {
            throw PengabdianException::pengabdianNotFound();
        }

        if (
            $pengabdian->status_kaprodi === StatusPenelitian::Pending ||
            $pengabdian->status_dppm === StatusPenelitian::Pending
        ) {
            throw PengabdianException::pengabdianCantApproved(
                "Pengabdian " . StatusPenelitian::Pending->message() . " kaprodi dan dppm."
            );
        }

        if (
            $pengabdian->status_keuangan->value === StatusPenelitian::Approval->value ||
            $pengabdian->status_keuangan->value === StatusPenelitian::Reject->value
        ) {
            throw PengabdianException::pengabdianCantApproved("Pengabdian {$pengabdian->status_dppm->message()}.");
        }

        $pengabdian->update([
            'status_keuangan' => StatusPenelitian::Approval,
        ]);

        return self::getPengabdianById($id);
    }

    public static function canceledPengabdian(string $keterangan, string $id)
    {
        $pengabdian = Pengabdian::byHash($id);

        if (! $pengabdian) {
            throw PengabdianException::pengabdianNotFound();
        }

        if (
            $pengabdian->status_kaprodi === StatusPenelitian::Pending ||
            $pengabdian->status_dppm === StatusPenelitian::Pending
        ) {
            throw PengabdianException::pengabdianCantApproved(
                "Pengabdian " . StatusPenelitian::Pending->message() . " kaprodi dan dppm."
            );
        }

        if (
            $pengabdian->status_keuangan->value === StatusPenelitian::Approval->value ||
            $pengabdian->status_keuangan->value === StatusPenelitian::Reject->value
        ) {
            throw PengabdianException::pengabdianCantApproved("Pengabdian {$pengabdian->status_dppm->message()}.");
        }

        $pengabdian->update([
            'status_keuangan' => StatusPenelitian::Reject,
            'keterangan' => $keterangan,
        ]);

        return self::getPengabdianById($id);
    }
}
