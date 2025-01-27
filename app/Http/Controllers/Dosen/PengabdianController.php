<?php

namespace App\Http\Controllers\Dosen;

use App\Helper\ResponseApi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Dosen\DataTransferObjects\PengabdianDto;
use Modules\Dosen\Interfaces\PengabdianServiceInterface;
use Modules\Dosen\Requests\PengabdianRequest;

class PengabdianController extends Controller
{
    public function __construct(
        protected PengabdianServiceInterface $service
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
                'status_kaprodi' => $request->input('status_kaprodi'),
                'status_dppm' => $request->input('status_dppm'),
                'status_keuangan' => $request->input('status_keuangan'),
            ],
            'order_by' => $request->input('order_by', 'created_at'),
            'order_direction' => $request->input('order_direction', 'desc'),
            'with' => [],
        ];

        $data = $this->service->getAllPengabdian($options);

        return ResponseApi::statusSuccess()
            ->message('Data Pengabdian berhasil diambil')
            ->data($data)
            ->json();
    }

    public function show(string $id)
    {
        return ResponseApi::statusSuccess()
            ->message('Data Pengabdian berhasil diambil')
            ->data($this->service->getPengabdianById($id))
            ->json();
    }

    public function store(PengabdianRequest $request)
    {
        $data = $this->service->insertPengabdian(
            PengabdianDto::fromRequest($request)
        );

        return ResponseApi::statusSuccessCreated()
            ->message('Data Pengabdian berhasil ditambahkan')
            ->data($data)
            ->json();
    }


    public function update(PengabdianRequest $request, $id)
    {
        $data = $this->service->updatePengabdian($id, PengabdianDto::fromRequest($request));

        return ResponseApi::statusSuccess()
            ->message('Data Pengabdian berhasil diubah')
            ->data($data)
            ->json();
    }

    public function destroy($id)
    {
        $this->service->deletePengabdian($id);

        return ResponseApi::statusSuccess()
            ->message('Data Pengabdian berhasil dihapus')
            ->json();
    }
}
