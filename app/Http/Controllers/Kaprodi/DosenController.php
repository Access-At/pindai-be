<?php

namespace App\Http\Controllers\Kaprodi;

use App\Helper\ResponseApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Kaprodi\DataTransferObjects\DosenDto;
use Modules\Kaprodi\Requests\DosenRequest;
use Modules\Kaprodi\Services\DosenService;

class DosenController extends Controller
{
    public function __construct(
        protected DosenService $service
    ) {}

    public function index(Request $request)
    {
        // Prodi::hashToId($request->input('prodi_id'))
        $options = [
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page'),
            'search' => $request->input('search'),
            'search_fields' => ['name', 'email'],
            'filters' => [
                'dosen.is_approved' => $request->input('is_approved'),
                'dosen.is_active' => $request->input('is_active'),
                'dosen.prodi_id' => $request->input('prodi_id'),
            ],
            'order_by' => $request->input('order_by', 'name'),
            'order_direction' => $request->input('order_direction', 'asc'),
            'with' => ['dosen.prodi', 'dosen.fakultas'],
        ];

        $data = $this->service->getAllDosen($options);

        return ResponseApi::statusSuccess()
            ->message('succes get dosen')
            ->data($data)
            ->json();
    }

    public function show($id)
    {
        $data = $this->service->getDosenById($id);

        return ResponseApi::statusSuccess()
            ->message('succes get dosen')
            ->data($data)
            ->json();
    }

    public function store(DosenRequest $request)
    {
        // DosenService::createDosen($request->validated());
        $this->service->insertDosen(
            DosenDto::fromRequest($request)
        );

        return ResponseApi::statusSuccess()
            ->message('berhasil tambah dosen')
            ->json();
    }

    public function update(DosenRequest $request, $id)
    {
        // DosenService::updateDosen($id, $request->validated());
        $this->service->updateDosen(
            $id,
            DosenDto::fromRequest($request)
        );

        return ResponseApi::statusSuccess()
            ->message('berhasil mengubah dosen')
            ->json();
    }

    public function approved($id)
    {
        $this->service->approvedDosen($id);

        return ResponseApi::statusSuccess()
            ->message('dosen telah disetujui')
            ->json();
    }

    public function active($id, Request $request)
    {
        // DosenService::activeDosen($id, $request->is_active);
        $this->service->activeDosen($id, $request->is_active);

        return ResponseApi::statusSuccess()
            ->message('berhasil mengubah status dosen')
            ->json();
    }

    public function destroy($id)
    {
        $this->service->deleteDosen($id);

        return ResponseApi::statusSuccess()
            ->message('berhasil menghapus dosen')
            ->json();
    }
}
