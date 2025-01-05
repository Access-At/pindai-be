<?php

namespace App\Http\Controllers\Dppm;

use Throwable;
use App\Helper\ResponseApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Dppm\DataTransferObjects\KaprodiDto;
use Modules\Dppm\Requests\KaprodiRequest;
use Modules\Dppm\Services\KaprodiService;

class KaprodiController extends Controller
{
    public function __construct(
        protected KaprodiService $service
    ) {}

    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10); // default 10
        $page = $request->get('page', 1); // default halaman 1
        $search = $request->get('search', '') ?? ''; // default filter kosong

        $data = $this->service->getAllKaprodi($perPage, $page, $search);

        return ResponseApi::statusSuccess()
            ->message('Data Kaprodi berhasil diambil')
            ->data($data)
            ->json();
    }

    public function show($id)
    {
        $data = $this->service->getKaprodiById($id);

        return ResponseApi::statusSuccess()
            ->message('Data Kaprodi berhasil diambil')
            ->data($data)
            ->json();
    }

    public function store(KaprodiRequest $request)
    {
        $this->service->insertKaprodi(
            KaprodiDto::fromRequest($request)
        );

        return ResponseApi::statusSuccessCreated()
            ->message('Data Kaprodi berhasil ditambahkan')
            ->json();
    }

    public function update(string $id, KaprodiRequest $request)
    {
        $this->service->updateKaprodi($id, KaprodiDto::fromRequest($request));

        return ResponseApi::statusSuccess()
            ->message('Data Kaprodi berhasil diubah')
            ->json();
    }

    public function destroy($id)
    {
        $this->service->deleteKaprodi($id);

        return ResponseApi::statusSuccess()
            ->message('Data Kaprodi berhasil dihapus')
            ->json();
    }
}
