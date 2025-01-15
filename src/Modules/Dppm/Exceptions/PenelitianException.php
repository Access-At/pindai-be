<?php

namespace Modules\Dppm\Exceptions;

use Modules\CustomException;

class PenelitianException extends CustomException
{
    public static function penelitianNotFound(): self
    {
        return new self('Penelitian tidak ditemukan.', 404, 'Get Penelitian');
    }

    public static function penelitianCantApproved($message): self
    {
        return new self("Penelitian tidak bisa disetujui. Dikarenakan $message", 422, 'Approval Penelitian');
    }

    public static function penelitianCantCanceled($message): self
    {
        return new self("Penelitian tidak bisa ditolak. Dikarenakan $message", 422, 'Canceled Penelitian');
    }
}
