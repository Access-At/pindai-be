<?php

namespace App\Http\Controllers\Dosen;

use App\Helper\ResponseApi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Dosen\Interfaces\TrackingServiceInterface;

class TrackingController extends Controller
{
    public function __construct(
        protected TrackingServiceInterface $service
    ) {}

    public function penelitianTracking(Request $request)
    {
        $options = [
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page'),
            'search' => $request->input('search'),
            'search_fields' => ['judul'],
            'filters' => [],
            'order_by' => $request->input('order_by', 'created_at'),
            'order_direction' => $request->input('order_direction', 'desc'),
            'with' => [],
        ];

        $data = $this->service->penelitianTracking($options);

        return ResponseApi::statusSuccess()
            ->message('success get tracking penelitian')
            ->data($data)
            ->json();
    }

    public function publikasiTracking(Request $request)
    {
        $options = [
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page'),
            'search' => $request->input('search'),
            'search_fields' => ['judul'],
            'filters' => [],
            'order_by' => $request->input('order_by', 'created_at'),
            'order_direction' => $request->input('order_direction', 'desc'),
            'with' => [],
        ];

        $data = $this->service->publikasiTracking($options);

        return ResponseApi::statusSuccess()
            ->message('success get tracking publikasi')
            ->data($data)
            ->json();
    }

    public function pengabdianTracking(Request $request)
    {
        $options = [
            'per_page' => $request->input('per_page', 10),
            'page' => $request->input('page'),
            'search' => $request->input('search'),
            'search_fields' => ['judul'],
            'filters' => [],
            'order_by' => $request->input('order_by', 'created_at'),
            'order_direction' => $request->input('order_direction', 'desc'),
            'with' => [],
        ];

        $data = $this->service->pengabdianTracking($options);

        return ResponseApi::statusSuccess()
            ->message('success get tracking publikasi')
            ->data($data)
            ->json();
    }
}
