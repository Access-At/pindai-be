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
        $name = $request->get('search') ?? '';

        $data = $this->service->getListDosen($name);

        return ResponseApi::statusSuccess()
            ->message('Success get list dosen')
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
