<?php

namespace App\Http\Controllers\Dosen;

use App\Enums\StatusPenelitian;
use App\Helper\EncryptData;
use App\Helper\ResponseApi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Modules\Dosen\DataTransferObjects\PenelitianDto;
use Modules\Dosen\Interfaces\PenelitianServiceInterface;
use Modules\Dosen\Requests\PenelitianRequest;

class PenelitianController extends Controller
{
    public function __construct(
        protected PenelitianServiceInterface $service
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

        $data = $this->service->getAllPenelitian($options);

        return ResponseApi::statusSuccess()
            ->message('Data Penelitian berhasil diambil')
            ->data($data)
            ->json();
    }

    public function show(string $id)
    {
        return ResponseApi::statusSuccess()
            ->message('Data Penelitian berhasil diambil')
            ->data($this->service->getPenelitianById($id))
            ->json();
    }

    public function store(PenelitianRequest $request)
    {
        $data = $this->service->insertPenelitian(
            PenelitianDto::fromRequest($request)
        );

        return ResponseApi::statusSuccessCreated()
            ->message('Data Penelitian berhasil ditambahkan')
            ->data($data)
            ->json();
    }

    // public function update(PenelitianRequest $request, $id)
    // {
    //     $data = $this->service->updatePenelitian($id, PenelitianDto::fromRequest($request));

    //     return ResponseApi::statusSuccess()
    //         ->message('Data Penelitian berhasil diubah')
    //         ->data($data)
    //         ->json();
    // }

    // public function destroy($id)
    // {
    //     $this->service->deletePenelitian($id);

    //     return ResponseApi::statusSuccess()
    //         ->message('Data Penelitian berhasil dihapus')
    //         ->json();
    // }
}
