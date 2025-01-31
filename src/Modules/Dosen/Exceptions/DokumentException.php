<?php

namespace Modules\Dosen\Exceptions;

use Modules\CustomException;
use Symfony\Component\HttpFoundation\Response;

class DokumentException extends CustomException
{
    public static function dataNotFound($category): self
    {
        $category = ucwords($category);

        return new self("Data {$category} tidak ditemukan.", Response::HTTP_NOT_FOUND, 'Get Data');
    }

    public static function fileCantDownload($title, $status, $category): self
    {
        $category = ucwords($category);

        return new self("Dokumen \"{$title}\" {$category} tidak bisa didownload dikarenakan {$category} {$status}", Response::HTTP_BAD_REQUEST, 'Download Dokumen');
    }

    public static function fileNotFound($title, $category): self
    {
        $category = ucwords($category);
        return new self("{$category} \"{$title}\" tidak ditemukan", Response::HTTP_NOT_FOUND, 'Get Dokumen');
    }

    

    // public static function penelitianNotFound(): self
    // {
    //     return new self('Penelitian tidak ditemukan.', 404, 'Get Penelitian');
    // }

    // public static function penlitianCantDownload($title, $status): self
    // {
    // return new self("Dokumen \"$title\" Penelitian tidak bisa didownload dikarenakan penelitian $status", Response::HTTP_BAD_REQUEST, 'Download Dokumen');
    // }
}
