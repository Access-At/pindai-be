<?php

namespace Modules\Kaprodi\Exceptions;

use Modules\CustomException;

class DosenException extends CustomException
{
    public static function dosenNotFound(): self
    {
        return new self('Dosen tidak ditemukan.', 404, "Get Dosen");
    }
}
