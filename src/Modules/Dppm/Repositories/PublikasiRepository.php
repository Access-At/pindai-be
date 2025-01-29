<?php

namespace Modules\Dppm\Repositories;

use App\Models\Publikasi;
use App\Enums\StatusPenelitian;
use Modules\Dppm\Exceptions\PublikasiException;

class PublikasiRepository
{
    public static function getAllPublikasi()
    {
        return Publikasi::with(['publikasi', 'kriteria']);
    }

    public static function getPublikasiById($id)
    {
        return Publikasi::with(['publikasi', 'kriteria'])->byHash($id)->first();
    }

    public static function approvedPublikasi(string $id)
    {
        $publikasi = Publikasi::byHash($id);

        if ( ! $publikasi) {
            throw PublikasiException::publikasiNotFound();
        }

        if ($publikasi->status_kaprodi === StatusPenelitian::Pending) {
            throw PublikasiException::publikasiCantApproved('Menunggu persetujuan kaprodi.');
        }

        if (
            $publikasi->status_dppm->value === StatusPenelitian::Approval->value ||
            $publikasi->status_dppm->value === StatusPenelitian::Reject->value
        ) {
            throw PublikasiException::publikasiCantApproved("publikasi sudah {$publikasi->status_dppm->name}.");
        }

        $publikasi->update([
            'status_dppm' => StatusPenelitian::Approval,
            'status_dppm_date' => now(),
        ]);

        return self::getPublikasiById($id);
    }

    public static function canceledPublikasi(string $keterangan, string $id)
    {
        $publikasi = Publikasi::byHash($id);

        if ( ! $publikasi) {
            throw PublikasiException::publikasiNotFound();
        }

        if ($publikasi->status_kaprodi === StatusPenelitian::Pending) {
            throw PublikasiException::publikasiCantCanceled('Menunggu persetujuan kaprodi.');
        }

        if (
            $publikasi->status_dppm->value === StatusPenelitian::Approval->value ||
            $publikasi->status_dppm->value === StatusPenelitian::Reject->value
        ) {
            throw PublikasiException::publikasiCantCanceled("publikasi sudah {$publikasi->status_dppm->name}.");
        }

        $publikasi->update([
            'status_dppm' => StatusPenelitian::Reject,
            'status_keuangan' => StatusPenelitian::Reject,
            'status_dppm_date' => now(),
            'status_keuangan_date' => now(),
            'keterangan' => $keterangan,
        ]);

        return self::getPublikasiById($id);
    }
}
