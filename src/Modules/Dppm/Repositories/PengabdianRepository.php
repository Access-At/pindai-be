<?php

namespace Modules\Dppm\Repositories;

use App\Models\Pengabdian;
use App\Enums\StatusPenelitian;
use Modules\Dppm\Exceptions\PengabdianException;

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

        if ($pengabdian->status_kaprodi === StatusPenelitian::Pending) {
            throw PengabdianException::pengabdianCantApproved(
                "Menunggu persetujuan kaprodi."
            );
        }

        if (
            $pengabdian->status_dppm->value === StatusPenelitian::Approval->value ||
            $pengabdian->status_dppm->value === StatusPenelitian::Reject->value
        ) {
            throw PengabdianException::pengabdianCantApproved("pengabdian sudah {$pengabdian->status_dppm->name}.");
        }

        $pengabdian->update([
            'status_dppm' => StatusPenelitian::Approval,
        ]);

        return self::getPengabdianById($id);
    }

    public static function canceledPengabdian(string $keterangan, string $id)
    {
        $pengabdian = Pengabdian::byHash($id);

        if (! $pengabdian) {
            throw PengabdianException::pengabdianNotFound();
        }

        if ($pengabdian->status_kaprodi === StatusPenelitian::Pending) {
            throw PengabdianException::pengabdianCantCanceled(
                "Menunggu persetujuan kaprodi."
            );
        }

        if (
            $pengabdian->status_dppm->value === StatusPenelitian::Approval->value ||
            $pengabdian->status_dppm->value === StatusPenelitian::Reject->value
        ) {
            throw PengabdianException::pengabdianCantCanceled("pengabdian sudah {$pengabdian->status_dppm->name}.");
        }

        $pengabdian->update([
            'status_dppm' => StatusPenelitian::Reject,
            'status_keuangan' => StatusPenelitian::Reject,
            'keterangan' => $keterangan,
        ]);

        return self::getPengabdianById($id);
    }
}
