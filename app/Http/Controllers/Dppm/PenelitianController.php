<?php

namespace App\Http\Controllers\Dppm;

use App\Helper\ResponseApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Dppm\DataTransferObjects\PenelitianDto;
use Modules\Dppm\Requests\PenelitianRequest;
use Modules\Dppm\Services\PenelitianService;

class PenelitianController extends Controller
{
    public function __construct(
        protected PenelitianService $service
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

        $data = $this->service->getAllPenelitian($options);

        return ResponseApi::statusSuccess()
            ->message('succes get penelitian')
            ->data($data)
            ->json();
    }

    public function show($id)
    {
        $data = $this->service->getPenelitianById($id);

        return ResponseApi::statusSuccess()
            ->message('succes get penelitian')
            ->data($data)
            ->json();
    }

    public function approved($id)
    {
        $data = $this->service->approvedPenelitian($id);

        return ResponseApi::statusSuccess()
            ->message('Penelitian telah disetujui')
            ->data($data)
            ->json();
    }

    public function canceled(PenelitianRequest $request, $id)
    {
        $data = $this->service->canceledPenelitian(
            PenelitianDto::fromRequest($request),
            $id
        );

        return ResponseApi::statusSuccess()
            ->message('Penelitian telah ditolak')
            ->data($data)
            ->json();
    }

    // public function store(DosenRequest $request) {}

    // public function update(DosenRequest $request, $id) {}

    // public function destroy($id) {}
}
