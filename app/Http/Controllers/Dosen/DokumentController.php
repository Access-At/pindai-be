<?php

namespace App\Http\Controllers\Dosen;

use App\Helper\ResponseApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Dosen\DataTransferObjects\DokumentDownloadDto;
use Modules\Dosen\DataTransferObjects\DokumentUploadDto;
use Modules\Dosen\Interfaces\DokumentServiceInterface;
use Modules\Dosen\Requests\DokumentDownloadRequest;
use Modules\Dosen\Requests\DokumentUploadRequest;

class DokumentController extends Controller
{
    public function __construct(
        protected DokumentServiceInterface $service
    ) {}

    public function download(DokumentDownloadRequest $request, string $id)
    {
        $data = $this->service->download(
            DokumentDownloadDto::fromRequest($request),
            $id
        );

        return ResponseApi::statusSuccess()
            ->message('Dokumen berhasil diunduh')
            ->download($data["path"], $data["name"]);
    }

    public function upload(DokumentUploadRequest $request, string $id)
    {
        $data = $this->service->upload(
            DokumentUploadDto::fromRequest($request),
            $id
        );

        return ResponseApi::statusSuccess()
            ->message('Dokumen berhasil diunggah')
            ->data($data)
            ->json();
    }
}
