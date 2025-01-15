<?php

namespace App\Http\Controllers\Dppm;

use App\Helper\ResponseApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Dppm\Requests\FakultasRequest;
use Modules\Dppm\DataTransferObjects\FakultasDto;
use Modules\Dppm\Interfaces\FakultasServiceInterface;

class FakultasController extends Controller
{
    public function __construct(
        protected FakultasServiceInterface $service
    ) {}

    public function index(Request $request)
    {
        $options = [
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page'),
            'search' => $request->input('search'),
            'search_fields' => ['name'],
            'filters' => [],
            'order_by' => $request->input('order_by', 'name'),
            'order_direction' => $request->input('order_direction', 'asc'),
            'with' => [],
        ];

        $data = $this->service->getAllFakultas($options);

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
