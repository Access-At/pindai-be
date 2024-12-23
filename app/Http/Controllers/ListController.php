<?php

namespace App\Http\Controllers;

use App\Helper\ResponseApi;
use App\Services\FakultasService;
use App\Services\ProdiService;
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
}
