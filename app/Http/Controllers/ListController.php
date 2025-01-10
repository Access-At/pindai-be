<?php

namespace App\Http\Controllers;

use App\Helper\ResponseApi;
use Illuminate\Http\Request;
use Modules\ListData\Interfaces\ListServiceInterface;

class ListController extends Controller
{
    public function __construct(
        protected ListServiceInterface $service
    ) {}

    public function getListFakultas()
    {
        $data = $this->service->getListFakultas();

        return ResponseApi::statusSuccess()
            ->message('Success get list fakultas')
            ->data($data)
            ->json();
    }

    public function getListProdi($fakultas)
    {
        $data = $this->service->getListProdi($fakultas);

        return ResponseApi::statusSuccess()
            ->message('Success get list prodi')
            ->data($data)
            ->json();
    }

    public function getListDosen(Request $request)
    {
        $perPage = $request->get('per_page', 10); // default 10
        $page = $request->get('page', 1); // default halaman 1
        $search = $request->get('search', '') ?? ''; // default filter kosong

        $data = $this->service->getListDosen($perPage, $page, $search);

        return ResponseApi::statusSuccess()
            ->message('Success get list dosen')
            ->data($data)
            ->json();
    }

    public function getListJenisIndeksasi()
    {
        $data = $this->service->getListJenisIndeksasi();
        return ResponseApi::statusSuccess()
            ->message('Success get list jenis indeksasi')
            ->data($data)
            ->json();
    }

    public function getListJenisPenelitian()
    {
        $data = $this->service->getListJenisPenelitian();
        return ResponseApi::statusSuccess()
            ->message('Success get list jenis penelitian')
            ->data($data)
            ->json();
    }

    public function getListJenisPengambdian()
    {
        $data = $this->service->getListJenisPengambdian();
        return ResponseApi::statusSuccess()
            ->message('Success get list jenis pengambdian')
            ->data($data)
            ->json();
    }

    public function getAuthorScholar(Request $request)
    {
        $name = $request->get('search');

        if ($name == null) {
            return ResponseApi::statusSuccess()
                ->message('Success get list author')
                ->data([])
                ->json();
        }

        $data = $this->service->getAuthorScholar($name);

        return ResponseApi::statusSuccess()
            ->message('Success get list author')
            ->data($data)
            ->json();
    }

    public function getAuthorProfileScholar($id)
    {
        $data = $this->service->getAuthorProfileScholar($id);

        return ResponseApi::statusSuccess()
            ->message('Success get author profile')
            ->data($data)
            ->json();
    }
}
