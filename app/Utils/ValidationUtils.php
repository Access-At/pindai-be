<?php

namespace App\Utils;

use App\Models\Penelitian;
use App\Enums\StatusPenelitian;
use Modules\Dosen\Exceptions\DokumentException;

class ValidationUtils
{
    public static function validatePenelitian(?Penelitian $penelitian, string $documentType): void
    {
        if (!$penelitian) {
            throw DokumentException::penelitianNotFound();
        }

        if (
            in_array($documentType, ['cover', 'surat_pengajuan', 'surat_rekomendasi', 'proposal'])
            && self::isPendingOrRejectedByKaprodi($penelitian)
        ) {
            throw DokumentException::penlitianCantDownload(ucwords(str_replace('_', ' ', $documentType)), "{$penelitian->status_kaprodi->message()} kaprodi");
        }

        if (in_array($documentType, ['kontrak_penelitian']) && self::isPendingOrRejectedByDPPM($penelitian)) {
            throw DokumentException::penlitianCantDownload("Kontrak Penelitian", "{$penelitian->status_dppm->message()} DPPM");
        }

        if (
            $documentType === 'surat_keterangan_selesai' &&
            self::isPendingOrRejectedByDPPM($penelitian) &&
            self::isPendingOrRejectedByKeuangan($penelitian)
        ) {
            throw DokumentException::penlitianCantDownload("Surat Keterangan Selesai", "{$penelitian->status_dppm->message()} DPPM atau keuangan");
        }
    }

    public static function isPendingOrRejectedByDPPM(Penelitian $penelitian): bool
    {
        return in_array($penelitian->status_dppm, [StatusPenelitian::Pending, StatusPenelitian::Reject]);
    }

    public static function isPendingOrRejectedByKaprodi(Penelitian $penelitian): bool
    {
        return in_array($penelitian->status_kaprodi, [StatusPenelitian::Pending, StatusPenelitian::Reject]);
    }

    public static function isPendingOrRejectedByKeuangan(Penelitian $penelitian): bool
    {
        return in_array($penelitian->status_keuangan, [StatusPenelitian::Pending, StatusPenelitian::Reject]);
    }
}
