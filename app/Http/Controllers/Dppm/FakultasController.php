<?php

namespace App\Http\Controllers\Dppm;

use Throwable;
use App\Helper\ResponseApi;
use Illuminate\Http\Request;
use App\Services\FakultasService;
use App\Http\Controllers\Controller;
use App\Http\Requests\FakultasRequest;

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
        try {
            return ResponseApi::statusSuccess()
                ->message('Data Fakultas berhasil diambil')
                ->data(FakultasService::getFakultasById($id))
                ->json();
        } catch (Throwable $th) {
            return ResponseApi::statusNotFound()
                ->message('Data Fakultas tidak ditemukan')
                ->json();
        }
    }

    public function store(FakultasRequest $request)
    {
        return ResponseApi::statusSuccessCreated()
            ->message('Data Fakultas berhasil ditambahkan')
            ->data(FakultasService::createFakultas($request->validated()))
            ->json();
    }

    public function update(FakultasRequest $request, $id)
    {
        try {
            return ResponseApi::statusSuccess()
                ->message('Data Fakultas berhasil diubah')
                ->data(FakultasService::updateFakultas($id, $request->validated()))
                ->json();
        } catch (Throwable $th) {
            return ResponseApi::statusNotFound()
                ->message('Data Fakultas tidak ditemukan')
                ->json();
        }
    }

    public function destroy($id)
    {
        try {
            return ResponseApi::statusSuccess()
                ->message('Data Fakultas berhasil dihapus')
                ->data((FakultasService::deleteFakultas($id)))
                ->json();
        } catch (Throwable $th) {
            return ResponseApi::statusNotFound()
                ->message('Data Fakultas tidak ditemukan')
                ->json();
        }
    }
}
