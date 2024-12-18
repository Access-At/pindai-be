<?php

namespace App\Http\Controllers;

use App\Helper\ResponseApi;
use App\Http\Requests\FakultasRequest;
use App\Services\FakultasService;
use Illuminate\Http\Request;

class FakultasController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10); // default 10
        $page = $request->get('page', 1); // default halaman 1
        $search = $request->get('search', ''); // default filter kosong

        $data = FakultasService::getAllFakultas($perPage, $page, $search);

        return ResponseApi::statusSuccess()
            ->message('Data Fakultas berhasil diambil')
            ->data($data)
            ->json();
    }

    public function show($id)
    {
        return ResponseApi::statusSuccess()
            ->message('Data Fakultas berhasil diambil')
            ->data(FakultasService::getFakultasById($id))
            ->json();
    }

    public function store(FakultasRequest $request)
    {
        return ResponseApi::statusSuccess()
            ->message('Data Fakultas berhasil ditambahkan')
            ->data(FakultasService::createFakultas($request->validated()))
            ->json();
    }

    public function update(FakultasRequest $request, $id)
    {
        return ResponseApi::statusSuccess()
            ->message('Data Fakultas berhasil diubah')
            ->data(FakultasService::updateFakultas($id, $request->validated()))
            ->json();
    }

    public function destroy($id)
    {
        return ResponseApi::statusSuccess()
            ->message('Data Fakultas berhasil dihapus')
            ->data((FakultasService::deleteFakultas($id)))
            ->json();
    }
}
