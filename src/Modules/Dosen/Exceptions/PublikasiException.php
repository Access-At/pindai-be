<?php

namespace Modules\Dosen\Exceptions;

use Modules\CustomException;

class PublikasiException extends CustomException
{
    public static function dosenNotFound(): self
    {
        return new self('Dosen tidak ditemukan.', 404, 'Get Dosen');
    }

    public static function PublikasiNotFound(): self
    {
        return new self('Publikasi tidak ditemukan.', 404, 'Get Publikasi');
    }

    public static function PublikasiNotDelete(): self
    {
        return new self('Publikasi tidak bisa dihapus. Dikarenakan kaprodi dan dppm sudah mensetujui publikasi ini', 422, 'Delete Publikasi');
    }
}
