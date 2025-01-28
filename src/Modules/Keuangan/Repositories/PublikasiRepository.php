<?php

namespace Modules\Keuangan\Repositories;

use App\Models\Publikasi;
use App\Enums\StatusPenelitian;
use Modules\Keuangan\Exceptions\PublikasiException;

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

        if (
            $publikasi->status_kaprodi === StatusPenelitian::Pending ||
            $publikasi->status_dppm === StatusPenelitian::Pending
        ) {
            throw PublikasiException::publikasiCantApproved('Publikasi ' . StatusPenelitian::Pending->message() . ' kaprodi dan dppm.');
        }

        if (
            $publikasi->status_keuangan->value === StatusPenelitian::Approval->value ||
            $publikasi->status_keuangan->value === StatusPenelitian::Reject->value
        ) {
            throw PublikasiException::publikasiCantApproved("publikasi sudah {$publikasi->status_keuangan->name}.");
        }

        $publikasi->update([
            'status_keuangan' => StatusPenelitian::Approval,
        ]);

        return self::getPublikasiById($id);
    }

    public static function canceledPublikasi(string $keterangan, string $id)
    {
        $publikasi = Publikasi::byHash($id);

        if ( ! $publikasi) {
            throw PublikasiException::publikasiNotFound();
        }

        if (
            $publikasi->status_kaprodi === StatusPenelitian::Pending ||
            $publikasi->status_dppm === StatusPenelitian::Pending
        ) {
            throw PublikasiException::publikasiCantApproved('Publikasi ' . StatusPenelitian::Pending->message() . ' kaprodi dan dppm.');
        }

        if (
            $publikasi->status_keuangan->value === StatusPenelitian::Approval->value ||
            $publikasi->status_keuangan->value === StatusPenelitian::Reject->value
        ) {
            throw PublikasiException::publikasiCantCanceled("publikasi sudah {$publikasi->status_keuangan->name}.");
        }

        $publikasi->update([
            'status_keuangan' => StatusPenelitian::Reject,
            'keterangan' => $keterangan,
        ]);

        return self::getPublikasiById($id);
    }
}
