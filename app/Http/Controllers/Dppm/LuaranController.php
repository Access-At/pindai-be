<?php

namespace App\Http\Controllers\Dppm;

use App\Helper\ResponseApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Dppm\Requests\LuaranRequest;
use Modules\Dppm\DataTransferObjects\LuaranDto;
use Modules\Dppm\Interfaces\LuaranServiceInterface;

class LuaranController extends Controller
{
    public function __construct(
        protected LuaranServiceInterface $service
    ) {}

    public function index(Request $request)
    {
        $options = [
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page'),
            'search' => $request->input('search'),
            'search_fields' => ['name'],
            'filters' => [
                'category' => $request->input('category'),
            ],
            'order_by' => $request->input('order_by', 'name'),
            'order_direction' => $request->input('order_direction', 'asc'),
            'with' => [],
        ];

        $data = $this->service->getAllLuaran($options);

        return ResponseApi::statusSuccess()
            ->message('Data Luaran berhasil diambil')
            ->data($data)
            ->json();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LuaranRequest $request)
    {
        $data = $this->service->insertLuaran(
            LuaranDto::fromRequest($request)
        );

        return ResponseApi::statusSuccessCreated()
            ->message('Data Luaran berhasil ditambahkan')
            ->data($data)
            ->json();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return ResponseApi::statusSuccess()
            ->message('Data Luaran berhasil diambil')
            ->data($this->service->getLuaranById($id))
            ->json();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LuaranRequest $request, string $id)
    {
        $data = $this->service->updateLuaran($id, LuaranDto::fromRequest($request));

        return ResponseApi::statusSuccess()
            ->message('Data Luaran berhasil diubah')
            ->data($data)
            ->json();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->service->deleteLuaran($id);

        return ResponseApi::statusSuccess()
            ->message('Data Luaran berhasil dihapus')
            ->json();
    }
}
