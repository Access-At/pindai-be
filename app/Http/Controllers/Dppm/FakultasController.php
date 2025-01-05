<?php

namespace App\Http\Controllers\Dppm;

use App\Helper\ResponseApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Dppm\DataTransferObjects\FakultasDto;
use Modules\Dppm\Interfaces\FakultasServiceInterface;
use Modules\Dppm\Requests\FakultasRequest;

class FakultasController extends Controller
{
    public function __construct(
        protected FakultasServiceInterface $service
    ) {}

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10); // default 10
        $page = $request->get('page', 1); // default halaman 1
        $search = $request->get('search', '') ?? ''; // default filter kosong

        $data = $this->service->getAllFakultas($perPage, $page, $search);

        return ResponseApi::statusSuccess()
            ->message('Data Fakultas berhasil diambil')
            ->data($data)
            ->json();
    }

    public function show(string $id)
    {
        return ResponseApi::statusSuccess()
            ->message('Data Fakultas berhasil diambil')
            ->data($this->service->getFakultasById($id))
            ->json();
    }

    public function store(FakultasRequest $request)
    {
        $data = $this->service->insertFakultas(
            FakultasDto::fromRequest($request)
        );

        return ResponseApi::statusSuccessCreated()
            ->message('Data Fakultas berhasil ditambahkan')
            ->data($data)
            ->json();
    }

    public function update(FakultasRequest $request, $id)
    {
        $data = $this->service->updateFakultas($id, FakultasDto::fromRequest($request));

        return ResponseApi::statusSuccess()
            ->message('Data Fakultas berhasil diubah')
            ->data($data)
            ->json();
    }

    public function destroy($id)
    {
        $this->service->deleteFakultas($id);

        return ResponseApi::statusSuccess()
            ->message('Data Fakultas berhasil dihapus')
            ->json();
    }
}
