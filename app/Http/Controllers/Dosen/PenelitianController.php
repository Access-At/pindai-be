<?php

namespace App\Http\Controllers\Dosen;

use App\Helper\ResponseApi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
        $perPage = $request->get('per_page', 10); // default 10
        $page = $request->get('page', 1); // default halaman 1
        $search = $request->get('search', '') ?? ''; // default filter kosong

        $data = $this->service->getAllPenelitian($perPage, $page, $search);

        return ResponseApi::statusSuccess()
            ->message('Data Fakultas berhasil diambil')
            ->data($data)
            ->json();
    }

    // public function show(string $id)
    // {
    //     return ResponseApi::statusSuccess()
    //         ->message('Data Fakultas berhasil diambil')
    //         ->data($this->service->getFakultasById($id))
    //         ->json();
    // }

    public function store(PenelitianRequest $request)
    {
        $data = $this->service->insertPenelitian(
            PenelitianDto::fromRequest($request)
        );

        return ResponseApi::statusSuccessCreated()
            ->message('Data Fakultas berhasil ditambahkan')
            ->data($data)
            ->json();
    }

    // public function update(FakultasRequest $request, $id)
    // {
    //     $data = $this->service->updateFakultas($id, FakultasDto::fromRequest($request));

    //     return ResponseApi::statusSuccess()
    //         ->message('Data Fakultas berhasil diubah')
    //         ->data($data)
    //         ->json();
    // }

    // public function destroy($id)
    // {
    //     $this->service->deleteFakultas($id);

    //     return ResponseApi::statusSuccess()
    //         ->message('Data Fakultas berhasil dihapus')
    //         ->json();
    // }
}
