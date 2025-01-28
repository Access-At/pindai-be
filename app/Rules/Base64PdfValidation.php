<?php

namespace App\Rules;

use finfo;
use Exception;
use Illuminate\Contracts\Validation\Rule;

class Base64PdfValidation implements Rule
{
    private $maxSizeInBytes; // Maksimal ukuran file dalam byte

    private $errorMessage;

    public function __construct($maxSizeInMB = 2)
    {
        // Konversi MB ke byte
        $this->maxSizeInBytes = $maxSizeInMB * 1024 * 1024;
    }

    public function passes($attribute, $value)
    {
        // Decode base64 string
        $decoded = base64_decode($value, true);

        if ($decoded === false) {
            $this->errorMessage = 'Format base64 tidak valid.';

            return false; // Jika decoding gagal
        }

        // Validasi ukuran file
        if (mb_strlen($decoded) > $this->maxSizeInBytes) {
            $this->errorMessage = 'Ukuran file melebihi batas maksimal ' . ($this->maxSizeInBytes / 1024 / 1024) . ' MB.';

            return false; // File melebihi batas ukuran
        }

        // Validasi MIME type
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($decoded);

        if ($mimeType !== 'application/pdf') {
            $this->errorMessage = 'File harus berformat PDF.';

            return false; // MIME type bukan PDF
        }

        // (Opsional) Validasi header PDF
        $pdfHeader = '%PDF-';
        if (mb_substr($decoded, 0, mb_strlen($pdfHeader)) !== $pdfHeader) {
            $this->errorMessage = 'File bukan merupakan file PDF yang valid.';

            return false; // Header file bukan PDF
        }

        // (Opsional) Tambahkan sanitasi atau parsing tambahan
        return $this->isSafePdf($decoded);
    }

    public function message()
    {
        return $this->errorMessage ?? 'File PDF tidak valid.';
    }

    private function isSafePdf($decoded)
    {
        try {
            $parser = new \Smalot\PdfParser\Parser;
            $pdf = $parser->parseContent($decoded);

            return true; // File PDF aman
        } catch (Exception $e) {
            $this->errorMessage = 'File PDF rusak atau tidak dapat dibaca.';

            return false; // Parsing gagal
        }
    }
}
