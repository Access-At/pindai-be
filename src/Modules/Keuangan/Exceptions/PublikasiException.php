<?php

namespace Modules\Keuangan\Exceptions;

use Modules\CustomException;

class PublikasiException extends CustomException
{
    public static function publikasiNotFound(): self
    {
        return new self('Publikasi tidak ditemukan.', 404, 'Get Publikasi');
    }

    public static function publikasiCantApproved($message): self
    {
        return new self("Publikasi tidak bisa disetujui. Dikarenakan {$message}", 422, 'Approval Publikasi');
    }

    public static function publikasiCantCanceled($message): self
    {
        return new self("Publikasi tidak bisa ditolak. Dikarenakan {$message}", 422, 'Canceled Publikasi');
    }
}
