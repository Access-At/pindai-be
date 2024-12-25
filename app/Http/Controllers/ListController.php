<?php

namespace App\Http\Controllers;

use App\Helper\ResponseApi;
use App\Services\DosenService;
use App\Services\ProdiService;
use App\Services\FakultasService;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function getListFakultas()
    {
        return ResponseApi::statusSuccess()
            ->message('Success get list fakultas')
            ->data(FakultasService::getListFakultas())
            ->json();
    }

    public function getListProdi($fakultas)
    {
        return ResponseApi::statusSuccess()
            ->message('Success get list prodi')
            ->data(ProdiService::getListProdi($fakultas))
            ->json();
    }

    public function getListDosen(Request $request)
    {
        $name = $request->get('search') ?? '';

        return ResponseApi::statusSuccess()
            ->message('Success get list dosen')
            ->data(DosenService::getListDosen($name))
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

        return ResponseApi::statusSuccess()
            ->message('Success get list author')
            ->data(DosenService::getAuthorScholar($name))
            ->json();
    }

    public function getAuthorProfileScholar($id)
    {
        return ResponseApi::statusSuccess()
            ->message('Success get author profile')
            ->data(DosenService::getAuthorProfileScholar($id))
            ->json();
    }
}
