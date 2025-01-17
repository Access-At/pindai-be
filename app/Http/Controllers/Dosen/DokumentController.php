<?php

namespace App\Http\Controllers\Dosen;

use App\Helper\ResponseApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Dosen\Requests\DokumentRequest;
use Modules\Dosen\DataTransferObjects\DokumentDto;
use Modules\Dosen\Interfaces\DokumentServiceInterface;

class DokumentController extends Controller
{
    public function __construct(
        protected DokumentServiceInterface $service
    ) {}

    public function download(DokumentRequest $request, string $id)
    {
        $data = $this->service->download(
            DokumentDto::fromRequest($request),
            $id
        );

        return ResponseApi::statusSuccess()
            ->message('Dokumen berhasil diunduh')
            ->download($data["path"], $data["name"]);
    }
}
