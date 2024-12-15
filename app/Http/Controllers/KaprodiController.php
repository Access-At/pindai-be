<?php

namespace App\Http\Controllers;

use App\Helper\ResponseApi;

class KaprodiController extends Controller
{
    public function index()
    {
        return ResponseApi::statusSuccess()
            ->message('Data Kaprodi berhasil diambil')
            ->data([])
            ->json();
    }
}
