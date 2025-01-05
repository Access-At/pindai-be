<?php

namespace Modules\ListData\Services;

use App\Helper\GoogleScholarScraper;
use Modules\ListData\Interfaces\ListServiceInterface;
use Modules\ListData\Repositories\ListRepository;
use Modules\ListData\Resources\DosenResource;
use Modules\ListData\Resources\FakultasResource;
use Modules\ListData\Resources\ProdiResource;
use Illuminate\Support\Facades\Cache;


class ListService implements ListServiceInterface
{
    public function getListFakultas()
    {
        return FakultasResource::collection(ListRepository::getListFakultas());
    }

    public function getListProdi($fakultas)
    {
        return ProdiResource::collection(ListRepository::getListProdi($fakultas));
    }

    public function getListDosen($name)
    {
        return DosenResource::collection(ListRepository::getListDosen($name));
    }

    public function getAuthorScholar($name)
    {
        return GoogleScholarScraper::searchAuthor($name);
    }

    public function getAuthorProfileScholar($id)
    {
        return Cache::remember("author_profile_$id", 18000, function () use ($id) { // 5 jam = 18000 detik
            return GoogleScholarScraper::getAuthorProfile($id);
        });
    }
}
