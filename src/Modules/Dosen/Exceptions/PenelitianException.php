<?php

namespace Modules\Dosen\Exceptions;

use Modules\CustomException;

class PenelitianException extends CustomException
{
    public static function dosenNotFound(): self
    {
        return new self('Dosen tidak ditemukan.', 404, "Get Dosen");
    }
}
