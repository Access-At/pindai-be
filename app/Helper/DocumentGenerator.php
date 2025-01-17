<?php

namespace App\Helper;

use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\Element\Table;
use PhpOffice\PhpWord\SimpleType\TblWidth;
use PhpOffice\PhpWord\SimpleType\Jc;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class DocumentGenerator
{
    private TemplateProcessor $templateProcessor;

    public function __construct(string $templatePath)
    {
        $fullPath = Storage::disk('public')->path($templatePath);
        $this->templateProcessor = new TemplateProcessor($fullPath);
    }

    /**
     * Set values for placeholders in the Word template.
     */
    public function setValues(array $values): void
    {
        $this->templateProcessor->setValues($values);
    }

    /**
     * Add a table to the Word template.
     */
    public function addTable(array $headers, array $rows): void
    {
        $table = new Table([
            'borderSize' => 5,
            'width' => 5000,
            'unit' => TblWidth::PERCENT,
        ]);

        // Add headers to the table
        $table->addRow();
        foreach ($headers as $header) {
            $table->addCell(150)->addText($header, [
                'bold' => true,
                'size' => 10,
                'name' => 'Times New Roman'
            ], ['alignment' => Jc::CENTER]);
        }

        // Add rows to the table
        foreach ($rows as $row) {
            $table->addRow();
            foreach ($row as $cell) {
                $table->addCell(150)->addText($cell, ['size' => 10, 'name' => 'Times New Roman']);
            }
        }

        $this->templateProcessor->setComplexBlock('table', $table);
    }

    public function setImageValue(string $placeholder, array $imageData): void
    {
        $this->templateProcessor->setImageValue($placeholder, $imageData);
    }

    /**
     * Save the generated document.
     */
    public function save(string $outputPath): void
    {
        $this->templateProcessor->saveAs($outputPath);

        // Hapus gambar sementara jika ada
        $tempImagePath = storage_path('app/public/out/temp_image.png');
        if (file_exists($tempImagePath)) {
            unlink($tempImagePath);
        }
    }

    public function getDocumentContent(): string
    {
        return $this->templateProcessor->getTempDocumentFilename();
    }
}
