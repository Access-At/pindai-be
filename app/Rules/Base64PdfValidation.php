<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Base64PdfValidation implements Rule
{
    private $maxSizeInBytes; // Maksimal ukuran file dalam byte

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
            return false; // Jika decoding gagal
        }

        // Validasi ukuran file
        if (strlen($decoded) > $this->maxSizeInBytes) {
            return false; // File melebihi batas ukuran
        }

        // Validasi MIME type
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($decoded);

        if ($mimeType !== 'application/pdf') {
            return false; // MIME type bukan PDF
        }

        // (Opsional) Validasi header PDF
        $pdfHeader = '%PDF-';
        if (substr($decoded, 0, strlen($pdfHeader)) !== $pdfHeader) {
            return false; // Header file bukan PDF
        }

        // (Opsional) Tambahkan sanitasi atau parsing tambahan
        return $this->isSafePdf($decoded);
    }

    private function isSafePdf($decoded)
    {
        try {
            $parser = new \Smalot\PdfParser\Parser();
            $pdf = $parser->parseContent($decoded);
            return true; // File PDF aman
        } catch (\Exception $e) {
            return false; // Parsing gagal
        }

        // Jika sanitasi belum digunakan, default-nya dianggap aman
        return true;
    }

    public function message()
    {
        return 'The file must be a valid PDF.';
    }
}
