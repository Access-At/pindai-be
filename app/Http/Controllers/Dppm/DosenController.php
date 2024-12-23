<?php

namespace App\Http\Controllers\Dppm;

use App\Helper\ResponseApi;
use App\Http\Controllers\Controller;
use App\Services\DosenService;
use Illuminate\Http\Request;


class DosenController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10); // default 10
        $page = $request->get('page', 1); // default halaman 1
        $search = $request->get('search', ''); // default filter kosong

        $data = DosenService::getAllDosen($perPage, $page, $search);

        return ResponseApi::statusSuccess()
            ->message('succes get dosen')
            ->data($data)
            ->json();
    }

    public function show($id)
    {
        $data = DosenService::getDosenById($id);
        return ResponseApi::statusSuccess()
            ->message('succes get dosen')
            ->data($data)
            ->json();
    }
}
