<?php

namespace Modules\Kaprodi\Exceptions;

use Modules\CustomException;

class PenelitianException extends CustomException
{
    public static function penelitianNotFound(): self
    {
        return new self('Penelitian tidak ditemukan.', 404, "Get Penelitian");
    }

    public static function penelitianCantApproved($status): self
    {
        return new self("Penelitian tidak bisa disetujui. Dikarenakan penelitian sudah $status", 422, "Approval Penelitian");
    }

    public static function penelitianCantCanceled($status): self
    {
        return new self("Penelitian tidak bisa ditolak. Dikarenakan penelitian sudah $status.", 422, "Canceled Penelitian");
    }
}
