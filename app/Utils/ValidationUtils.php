<?php

namespace App\Utils;

use App\Models\Penelitian;
use App\Models\Pengabdian;
use App\Enums\StatusPenelitian;
use Modules\Dosen\Exceptions\DokumentException;

class ValidationUtils
{
    public static function validatePenelitian(Penelitian|Pengabdian|null $penelitian, string $documentType, string $category): void
    {
        if (!$penelitian) {
            throw DokumentException::dataNotFound($category);
        }

        if (
            in_array($documentType, ['cover', 'surat_pengajuan', 'surat_rekomendasi', 'proposal'])
            && self::isPendingOrRejectedByKaprodi($penelitian)
        ) {
            throw DokumentException::fileCantDownload(ucwords(str_replace('_', ' ', $documentType)), "{$penelitian->status_kaprodi->message()} kaprodi", $category);
        }

        if (in_array($documentType, ['kontrak_penelitian']) && self::isPendingOrRejectedByDPPM($penelitian)) {
            throw DokumentException::fileCantDownload("Kontrak Penelitian", "{$penelitian->status_dppm->message()} DPPM", $category);
        }

        if (
            $documentType === 'surat_keterangan_selesai' &&
            self::isPendingOrRejectedByDPPM($penelitian) &&
            self::isPendingOrRejectedByKeuangan($penelitian)
        ) {
            throw DokumentException::fileCantDownload("Surat Keterangan Selesai", "{$penelitian->status_dppm->message()} DPPM atau keuangan", $category);
        }
    }

    public static function isPendingOrRejectedByDPPM(Penelitian|Pengabdian $penelitian): bool
    {
        return in_array($penelitian->status_dppm, [StatusPenelitian::Pending, StatusPenelitian::Reject]);
    }

    public static function isPendingOrRejectedByKaprodi(Penelitian|Pengabdian $penelitian): bool
    {
        return in_array($penelitian->status_kaprodi, [StatusPenelitian::Pending, StatusPenelitian::Reject]);
    }

    public static function isPendingOrRejectedByKeuangan(Penelitian|Pengabdian $penelitian): bool
    {
        return in_array($penelitian->status_keuangan, [StatusPenelitian::Pending, StatusPenelitian::Reject]);
    }
}
