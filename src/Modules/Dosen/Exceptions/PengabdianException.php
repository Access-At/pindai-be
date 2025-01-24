<?php

namespace Modules\Dosen\Exceptions;

use Modules\CustomException;

class PengabdianException extends CustomException
{
    public static function dosenNotFound(): self
    {
        return new self('Dosen tidak ditemukan.', 404, 'Get Dosen');
    }

    public static function PengabdianNotFound(): self
    {
        return new self('Pengabdian tidak ditemukan.', 404, 'Get Pengabdian');
    }
}
