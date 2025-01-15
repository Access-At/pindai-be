<?php

namespace Modules\Dosen\Services;

use App\Models\User;
use App\Helper\PaginateHelper;
use Modules\Dosen\Resources\DosenResource;
use Modules\Dosen\Resources\DokumentResource;
use Modules\Dosen\DataTransferObjects\DokumentDto;
use Modules\Dosen\Repositories\DokumentRepository;
use Modules\Dosen\Resources\DetailDokumentResource;
use Modules\Dosen\Interfaces\DokumentServiceInterface;
use Modules\Dosen\Resources\Pagination\DokumentPaginationCollection;

class DokumentService implements DokumentServiceInterface
{
    public function download(DokumentDto $request, string $id)
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();
        $section = $phpWord->addSection();

        $section->addText(
            "Surat Pengajuan Ke PRODI",
            ['size' => 16, 'bold' => true],
            ['alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER]
        );

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save('helloWorld.docx');


        dd($request, $id);
    }
}
