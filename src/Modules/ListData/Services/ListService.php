<?php

namespace Modules\ListData\Services;

use App\Helper\PaginateHelper;
use App\Helper\GoogleScholarScraper;
use Illuminate\Support\Facades\Cache;
use Modules\ListData\Resources\ProdiResource;
use Modules\ListData\Resources\FakultasResource;
use Modules\ListData\Repositories\ListRepository;
use Modules\ListData\Interfaces\ListServiceInterface;
use Modules\ListData\Resources\JenisPublikasiResource;
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

    public function getListDosen(array $options)
    {
        $data = PaginateHelper::paginate(
            ListRepository::getListDosen(),
            $options,
        );

        return new DosenPaginationCollection($data);
    }

    public function getAuthorScholar($name)
    {
        return Cache::remember("author_scholar_{$name}", 10800, function () use ($name) { // 3 jam = 10800 detik
            return GoogleScholarScraper::searchAuthor($name);
        });
    }

    public function getAuthorProfileScholar($id)
    {
        // return GoogleScholarScraper::getAuthorProfile($id);

        return Cache::remember("author_profile_{$id}", 18000, function () use ($id) { // 5 jam = 18000 detik
            return GoogleScholarScraper::getAuthorProfile($id);
        });
    }

    public function getListJenisPublikasi()
    {
        return JenisPublikasiResource::collection(ListRepository::getListJenisPublikasi());
    }

    public function getListJenisPenelitian()
    {
        return JenisPenelitianResource::collection(ListRepository::getListJenisPenelitian());
    }

    public function getListJenisPengabdian()
    {
        return JenisPengabdianResource::collection(ListRepository::getListJenisPengambdian());
    }
}
