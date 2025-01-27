<?php

namespace App\Http\Controllers\Dosen;

use App\Helper\ResponseApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Modules\Dosen\Requests\PublikasiRequest;
use Modules\Dosen\DataTransferObjects\PublikasiDto;
use Modules\Dosen\Interfaces\PublikasiServiceInterface;

use Illuminate\Support\Facades\Log;

class PublikasiController extends Controller
{
    public function __construct(
        protected PublikasiServiceInterface $service
    ) {}

    public function index(Request $request)
    {
        $options = [
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page'),
            'search' => $request->input('search'),
            'search_fields' => ['judul', 'authors', 'jurnal'],
            'filters' => [
                'status_kaprodi' => $request->input('status_kaprodi'),
                'status_dppm' => $request->input('status_dppm'),
                'status_keuangan' => $request->input('status_keuangan'),
            ],
            'order_by' => $request->input('order_by', 'created_at'),
            'order_direction' => $request->input('order_direction', 'desc'),
            'with' => [],
        ];

        $data = $this->service->getAllPublikasi($options);

        return ResponseApi::statusSuccess()
            ->message('Data Publikasi berhasil diambil')
            ->data($data)
            ->json();
    }

    public function show(string $id)
    {
        return ResponseApi::statusSuccess()
            ->message('Data Publikasi berhasil diambil')
            ->data($this->service->getPublikasiById($id))
            ->json();
    }

    public function store(PublikasiRequest $request)
    {
        $data = $this->service->insertPublikasi(
            PublikasiDto::fromRequest($request)
        );

        return ResponseApi::statusSuccessCreated()
            ->message('Data Publikasi berhasil ditambahkan')
            ->data($data)
            ->json();
    }

    public function update(PublikasiRequest $request, $id)
    {
        $data = $this->service->updatePublikasi($id, PublikasiDto::fromRequest($request));

        return ResponseApi::statusSuccess()
            ->message('Data Publikasi berhasil diubah')
            ->data($data)
            ->json();
    }

    public function destroy($id)
    {
        $this->service->deletePublikasi($id);

        return ResponseApi::statusSuccess()
            ->message('Data Publikasi berhasil dihapus')
            ->json();
    }
}
