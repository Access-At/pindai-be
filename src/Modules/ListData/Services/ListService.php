<?php

namespace Modules\ListData\Services;

use App\Helper\GoogleScholarScraper;
use Modules\ListData\Interfaces\ListServiceInterface;
use Modules\ListData\Repositories\ListRepository;
use Modules\ListData\Resources\FakultasResource;
use Modules\ListData\Resources\ProdiResource;
use Illuminate\Support\Facades\Cache;
use Modules\ListData\Resources\JenisIndeksasiResource;
use Modules\ListData\Resources\JenisPenelitianResource;
use Modules\ListData\Resources\JenisPengabdianResource;
use Modules\ListData\Resources\Pagination\DosenPaginationCollection;

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

    public function getListDosen(int $perPage, int $page, string $search)
    {
        return new DosenPaginationCollection(ListRepository::getListDosen($perPage, $page, $search));
    }

    public function getAuthorScholar($name)
    {
        return GoogleScholarScraper::searchAuthor($name);
    }

    public function getAuthorProfileScholar($id)
    {
        return Cache::remember("author_profile_$id", 60, function () use ($id) { // 5 jam = 18000 detik
            return GoogleScholarScraper::getAuthorProfile($id);
        });
    }

    public function getListJenisIndeksasi()
    {
        return JenisIndeksasiResource::collection(ListRepository::getListJenisIndeksasi());
    }

    public function getListJenisPenelitian()
    {
        return JenisPenelitianResource::collection(ListRepository::getListJenisPenelitian());
    }

    public function getListJenisPengambdian()
    {
        return JenisPengabdianResource::collection(ListRepository::getListJenisPengambdian());
    }
}
