<?php

namespace App\Http\Controllers\Dppm;

use App\Helper\ResponseApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Prodi;
use Hashids\Hashids;
use Modules\Dppm\Interfaces\DosenServiceInterface;

class DosenController extends Controller
{
    public function __construct(
        protected DosenServiceInterface $service
    ) {}

    public function index(Request $request)
    {
        $options = [
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page'),
            'search' => $request->input('search'),
            'search_fields' => ['name', 'email'],
            'filters' => [
                'dosen.is_approved' => $request->input('is_approved'),
                'dosen.is_active' => $request->input('is_active'),
                'dosen.prodi_id' => Prodi::hashToId($request->input('prodi_id')),
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
}
