<?php

namespace App\Http\Controllers\Dppm;

use App\Helper\ResponseApi;
use App\Http\Controllers\Controller;
use App\Http\Requests\DppmKaprodiRequest;
use App\Models\Kaprodi;
use App\Models\User;
use App\Services\KaprodiService;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class KaprodiController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10); // default 10
        $page = $request->get('page', 1); // default halaman 1
        $search = $request->get('search', ''); // default filter kosong

        $data = KaprodiService::getAllKaprodi($perPage, $page, $search);

        return ResponseApi::statusSuccess()
            ->message('Data Kaprodi berhasil diambil')
            ->data($data)
            ->json();
    }

    public function show($id)
    {
        try {
            $data = KaprodiService::getKaprodiById($id);
            return ResponseApi::statusSuccess()
                ->message('Data Kaprodi berhasil diambil')
                ->data($data)
                ->json();
        } catch (\Throwable $th) {
            return ResponseApi::statusNotFound()
                ->message('Data Kaprodi tidak ditemukan')
                ->json();
        }
    }

    public function store(DppmKaprodiRequest $request)
    {
        KaprodiService::createKaprodi($request->validated());

        return ResponseApi::statusSuccessCreated()
            ->message('Data Kaprodi berhasil ditambahkan')
            ->json();
    }

    public function update(string $id, DppmKaprodiRequest $request)
    {
        try {
            KaprodiService::updateKaprodi($id, $request->validated());
            return ResponseApi::statusSuccess()
                ->message('Data Kaprodi berhasil diubah')
                ->json();
        } catch (\Throwable $th) {
            return ResponseApi::statusNotFound()
                ->message('Data Kaprodi tidak ditemukan')
                ->json();
        }
    }

    public function destroy($id)
    {
        try {
            KaprodiService::deleteKaprodi($id);
            return ResponseApi::statusSuccess()
                ->message('Data Kaprodi berhasil dihapus')
                ->json();
        } catch (\Throwable $th) {
            return ResponseApi::statusNotFound()
                ->message('Data Kaprodi tidak ditemukan')
                ->json();
        }
    }
}
