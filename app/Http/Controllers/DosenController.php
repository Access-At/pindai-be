<?php

namespace App\Http\Controllers;

use App\Helper\ResponseApi;

class DosenController extends Controller
{
    public function index()
    {
        return ResponseApi::statusSuccess()
            ->message('Data Dosen berhasil diambil')
            ->data([])
            ->json();
    }
}
