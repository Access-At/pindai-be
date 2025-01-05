<?php

namespace Modules\Dppm\Exceptions;

use Modules\CustomException;

class FakultasException extends CustomException
{
    public static function fakultasNotFound(): self
    {
        return new self('Data Fakultas tidak ditemukan', 404, 'Get Fakultas');
    }
}
