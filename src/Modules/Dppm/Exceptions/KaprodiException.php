<?php

namespace Modules\Dppm\Exceptions;

use Modules\CustomException;

class KaprodiException extends CustomException
{
    public static function kaprodiNotFound()
    {
        return new static('Kaprodi tidak ditemukan', 404, 'Get Kaprodi');
    }
}
