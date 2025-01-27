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
        $options = [
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page'),
            'search' => $request->input('search'),
            'search_fields' => ['name', 'nidn'],
            'filters' => [],
            'order_by' => $request->input('order_by', 'name'),
            'order_direction' => $request->input('order_direction', 'asc'),
            'with' => ['dosen.prodi', 'dosen.fakultas'],
        ];

        $data = $this->service->getListDosen($options);

        return ResponseApi::statusSuccess()
            ->message('succes get list dosen')
            ->data($data)
            ->json();
    }

    public function getListJenisPublikasi()
    {
        $data = $this->service->getListJenisPublikasi();

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

    public function getListJenisPengabdian()
    {
        $data = $this->service->getListJenisPengabdian();

        return ResponseApi::statusSuccess()
            ->message('Success get list jenis pengambdian')
            ->data($data)
            ->json();
    }

    public function getAuthorScholar(Request $request)
    {
        $name = $request->get('search');

        if ($name === null) {
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
