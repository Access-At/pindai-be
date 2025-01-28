<?php

namespace App\Http\Controllers\Kaprodi;

use App\Helper\ResponseApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Kaprodi\Requests\PublikasiRequest;
use Modules\Kaprodi\Services\PublikasiService;
use Modules\Kaprodi\DataTransferObjects\PublikasiDto;

class PublikasiController extends Controller
{
    public function __construct(
        protected PublikasiService $service
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
            ->message('succes get publikasi')
            ->data($data)
            ->json();
    }

    public function show($id)
    {
        $data = $this->service->getPublikasiById($id);

        return ResponseApi::statusSuccess()
            ->message('succes get publikasi')
            ->data($data)
            ->json();
    }

    public function approved($id)
    {
        $data = $this->service->approvedPublikasi($id);

        return ResponseApi::statusSuccess()
            ->message('Publikasi telah disetujui')
            ->data($data)
            ->json();
    }

    public function canceled(PublikasiRequest $request, $id)
    {
        $data = $this->service->canceledPublikasi(
            PublikasiDto::fromRequest($request),
            $id
        );

        return ResponseApi::statusSuccess()
            ->message('Publikasi telah ditolak')
            ->data($data)
            ->json();
    }

    // public function store(DosenRequest $request) {}

    // public function update(DosenRequest $request, $id) {}

    // public function destroy($id) {}
}
