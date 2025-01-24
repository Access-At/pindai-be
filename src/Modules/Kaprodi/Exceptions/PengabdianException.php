<?php

namespace Modules\Kaprodi\Exceptions;

use Modules\CustomException;

class PengabdianException extends CustomException
{
    public static function pengabdianNotFound(): self
    {
        return new self('Pengabdian tidak ditemukan.', 404, 'Get Pengabdian');
    }

    public static function pengabdianCantApproved($status): self
    {
        return new self("Pengabdian tidak bisa disetujui. Dikarenakan pengabdian sudah {$status}", 422, 'Approval Pengabdian');
    }

    public static function pengabdianCantCanceled($status): self
    {
        return new self("Pengabdian tidak bisa ditolak. Dikarenakan pengabdian sudah {$status}.", 422, 'Canceled Pengabdian');
    }
}
