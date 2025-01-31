<?php

namespace App\Http\Controllers\Dosen;

use App\Helper\ResponseApi;
use App\Http\Controllers\Controller;
use Modules\Dosen\Requests\DokumentUploadRequest;
use Modules\Dosen\Requests\DokumentDownloadRequest;
use Modules\Dosen\Interfaces\DokumentServiceInterface;
use Modules\Dosen\DataTransferObjects\DokumentUploadDto;
use Modules\Dosen\DataTransferObjects\DokumentDownloadDto;

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
            ->download($data['path'], $data['name'], true);
    }

    public function downloadDokumen(DokumentDownloadRequest $request, string $id)
    {
        $data = $this->service->downloadDokumen(
            DokumentDownloadDto::fromRequest($request),
            $id
        );

        return ResponseApi::statusSuccess()
            ->message('Dokumen berhasil diunduh')
            ->download($data['path'], $data['name']);
    }

    public function upload(DokumentUploadRequest $request, string $id)
    {
        $data = $this->service->upload(
            DokumentUploadDto::fromRequest($request),
            $id
        );

        return ResponseApi::statusSuccess()
            ->message('Dokumen berhasil diunggah')
            ->data([])
            ->json();
    }
}
