<?php

namespace Modules\Dosen\Services;

use Illuminate\Support\Facades\Storage;
use Modules\Dosen\DataTransferObjects\DokumentDto;
use Modules\Dosen\Interfaces\DokumentServiceInterface;

class DokumentService implements DokumentServiceInterface
{
    public function download(DokumentDto $request, string $id)
    {
        $template = storage_path('app/public/doc/template.docx');
        $phpWord = new \PhpOffice\PhpWord\TemplateProcessor($template);
        $title = strtoupper("Surat Pengajuan Ke PRODI");

        $phpWord->setValues([
            'title' => $title,
            'prodi' => 'Sistem Informasi',
            'perihal' => 'Pengajuan Pelaksanaan Penelitian Dosen',
            'ketua.nama' => 'si kontol',
            'ketua.nidn' => '1234567890',
            'ketua.prodi' => 'Sistem Informasi',
            'ketua.jf' => 'Dosen Ganteng',
            'semester' => 'Genap',
            'tahun_ajaran' => '2023/2024',
            'judul_penelitian' => 'Judul Penelitian',
        ]);

        $phpWord->saveAs('surat.docx');

        // $section = $phpWord->addSection();

        // Menambahkan teks dengan font Times New Roman, ukuran 12, bold, dan rata tengah
        // $section->addText(
        //     "Surat Pengajuan Ke PRODI",
        //     [
        //         'size' => 12,
        //         'bold' => true,
        //         'name' => 'Times New Roman', // Properti name digunakan untuk font
        //         'allCaps' => true, // Menggunakan huruf besar (uppercase)
        //     ],
        //     [
        //         'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
        //     ]
        // );

        // Adding Text element with font customized using explicitly created font style object...
        // $fontStyle = new \PhpOffice\PhpWord\Style\Font();
        // $fontStyle->setBold(true);
        // $fontStyle->setName('Times New Roman');
        // $fontStyle->setSize(12);
        // $fontStyle->setAllCaps(true);
        // $myTextElement = $section->addText('Surat Pengajuan Ke PRODI');
        // $myTextElement->setFontStyle($fontStyle);
        // $myTextElement->setParagraphStyle(
        //     [
        //         'alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER,
        //     ]
        // );

        // $header = $section->addHeader();
        // $bg_image = Storage::disk('public')->get('images/LOGO_UNIVERSITAS_PELITA_BANGSA.png');

        // $header->addWatermark($bg_image, [
        //     'marginTop' => 1000,
        //     'positioning' => 'relative',
        //     'wrappingStyle' => 'behind',
        // 'width' => 250,
        // 'height' => 250,
        // ]);

        // $header->addWatermark($bg_image, [
        //     'width' => 250,
        //     'height' => 250,
        //     'marginTop' => 1000,
        //     'marginLeft' => 1000,
        //     'positioning' => 'absolute', // Posisi absolut
        //     'posHorizontal' => \PhpOffice\PhpWord\Style\Image::POSITION_HORIZONTAL_CENTER, // Posisi horizontal center
        //     'posVertical' => \PhpOffice\PhpWord\Style\Image::POSITION_VERTICAL_CENTER, // Posisi vertikal center
        //     'wrappingStyle' => 'behind', // Letakkan di belakang teks
        // ]);


        // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        // $objWriter->save('helloWorld.docx');

        dd($request, $id);
    }
}
