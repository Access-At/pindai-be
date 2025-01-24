<?php

namespace App\Http\Controllers\Dppm;

use App\Helper\ResponseApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Dppm\DataTransferObjects\PengabdianDto;
use Modules\Dppm\Requests\PengabdianRequest;
use Modules\Dppm\Services\PengabdianService;

class PengabdianController extends Controller
{
    public function __construct(
        protected PengabdianService $service
    ) {}

    public function index(Request $request)
    {
        $options = [
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page'),
            'search' => $request->input('search'),
            'search_fields' => ['judul'],
            'filters' => [
                'tahun_akademik' => $request->input('tahun_akademik'),
            ],
            'order_by' => $request->input('order_by', 'created_at'),
            'order_direction' => $request->input('order_direction', 'desc'),
            'with' => [],
        ];

        $data = $this->service->getAllPengabdian($options);

        return ResponseApi::statusSuccess()
            ->message('succes get pengabdian')
            ->data($data)
            ->json();
    }

    public function show($id)
    {
        $data = $this->service->getPengabdianById($id);

        return ResponseApi::statusSuccess()
            ->message('succes get pengabdian')
            ->data($data)
            ->json();
    }

    public function approved($id)
    {
        $data = $this->service->approvedPengabdian($id);

        return ResponseApi::statusSuccess()
            ->message('Pengabdian telah disetujui')
            ->data($data)
            ->json();
    }

    public function canceled(PengabdianRequest $request, $id)
    {
        $data = $this->service->canceledPengabdian(
            PengabdianDto::fromRequest($request),
            $id
        );

        return ResponseApi::statusSuccess()
            ->message('Pengabdian telah ditolak')
            ->data($data)
            ->json();
    }

    // public function store(DosenRequest $request) {}

    // public function update(DosenRequest $request, $id) {}

    // public function destroy($id) {}
}
