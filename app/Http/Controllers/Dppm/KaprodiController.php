<?php

namespace App\Http\Controllers\Dppm;

use Throwable;
use App\Helper\ResponseApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Faculty;
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
        $options = [
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page'),
            'search' => $request->input('search'),
            'search_fields' => ['name', 'email'],
            'filters' => [
                'kaprodi.is_active' => $request->input('is_active'),
                'kaprodi.faculties_id' => Faculty::hashToId($request->input('fakultas_id')),
            ],
            'order_by' => $request->input('order_by', 'name'),
            'order_direction' => $request->input('order_direction', 'asc'),
            'with' => ['kaprodi.faculty'],
        ];

        $data = $this->service->getAllKaprodi($options);

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
