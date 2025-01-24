<?php

namespace Modules\Dppm\Exceptions;

use Modules\CustomException;

class PengabdianException extends CustomException
{
    public static function pengabdianNotFound(): self
    {
        return new self('Pengabdian tidak ditemukan.', 404, 'Get Pengabdian');
    }

    public static function pengabdianCantApproved($message): self
    {
        return new self("Pengabdian tidak bisa disetujui. Dikarenakan $message", 422, 'Approval Pengabdian');
    }

    public static function pengabdianCantCanceled($message): self
    {
        return new self("Pengabdian tidak bisa ditolak. Dikarenakan $message", 422, 'Canceled Pengabdian');
    }
}
