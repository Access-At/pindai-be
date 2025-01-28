<?php

namespace Modules\Kaprodi\Repositories;

use App\Models\User;
use App\Models\Prodi;
use App\Models\Publikasi;
use App\Enums\StatusPenelitian;
use Modules\Kaprodi\Exceptions\PublikasiException;

class PublikasiRepository
{
    public static function getAllPublikasi()
    {
        $user = auth('api')->user();

        $userLogin = User::where('id', $user->id)
            ->with('kaprodi.faculty')
            ->first();

        $prodi = Prodi::where('faculties_id', $userLogin->kaprodi->faculty->id)
            ->get()
            ->pluck('id');

        return Publikasi::with(['publikasi', 'kriteria'])->ProdiPublikasi(
            $prodi
        );
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
            $publikasi->status_kaprodi->value === StatusPenelitian::Approval->value ||
            $publikasi->status_kaprodi->value === StatusPenelitian::Reject->value
        ) {
            throw PublikasiException::publikasiCantApproved("publikasi sudah {$publikasi->status_kaprodi->name}.");
        }

        $publikasi->update([
            'status_kaprodi' => StatusPenelitian::Approval,
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
            $publikasi->status_kaprodi->value === StatusPenelitian::Approval->value ||
            $publikasi->status_kaprodi->value === StatusPenelitian::Reject->value
        ) {
            throw PublikasiException::publikasiCantCanceled("publikasi sudah {$publikasi->status_kaprodi->name}.");
        }

        $publikasi->update([
            'status_kaprodi' => StatusPenelitian::Reject,
            'status_dppm' => StatusPenelitian::Reject,
            'status_keuangan' => StatusPenelitian::Reject,
            'keterangan' => $keterangan,
        ]);

        return self::getPublikasiById($id);
    }
}
