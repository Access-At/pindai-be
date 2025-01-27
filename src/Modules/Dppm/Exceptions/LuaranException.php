<?php

namespace Modules\Dppm\Exceptions;

use Modules\CustomException;

class LuaranException extends CustomException
{
    public static function LuaranNotFound(): self
    {
        return new self('Data Luaran tidak ditemukan', 404, 'Get Luaran');
    }
}
