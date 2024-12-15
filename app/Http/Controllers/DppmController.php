<?php

namespace App\Http\Controllers;

use App\Helper\ResponseApi;

class DppmController extends Controller
{
    public function index()
    {
        return ResponseApi::statusSuccess()
            ->message('Data DPPM berhasil diambil')
            ->data([
                'nama' => 'John Doe',
                'umur' => 30,
            ])
            ->json();
    }
}
