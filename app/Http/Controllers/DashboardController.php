<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getDashboardDppm()
    {
        return DashboardService::getDashboardDppm();
        // return view('dashboard');
    }

    public function getDashboardDosen()
    {
        // return view('dashboard');
    }

    public function getDashboardKaprodi()
    {
        // return view('dashboard');
    }
}
