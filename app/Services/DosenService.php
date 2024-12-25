<?php

namespace App\Services;

use App\Helper\GoogleScholarScraper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Repositories\DosenRepository;
use App\Http\Resources\Dppm\DosenResource;
use App\Http\Resources\Pagination\DosenPaginationCollection;

class DosenService
{
    public static function getAllDosen($perPage, $page, $search)
    {
        return new DosenPaginationCollection(DosenRepository::getAllDosen($perPage, $page, $search));
    }

    public static function getListDosen($name)
    {
        return DosenResource::collection(DosenRepository::getListDosen($name));
    }

    public static function getAuthorScholar($name)
    {
        return GoogleScholarScraper::searchAuthor($name);
    }

    public static function getAuthorProfileScholar($id)
    {
        return GoogleScholarScraper::getAuthorProfile($id);
    }

    public static function getDosenById($id)
    {
        return new DosenResource(DosenRepository::getDosenById($id));
    }

    public static function createDosen($data)
    {
        $password = Str::random(8);

        // Kirim email dengan password
        Mail::to($data['email'])->queue(new \App\Mail\SendEmail([
            'view' => 'emails.Register',
            'subject' => 'Password Akun Dosen',
            'menuju' => 'Dosen',
            'oleh' => 'Kaprodi',
            'data' => [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $password,
            ],
        ]));

        $data['password'] = bcrypt($password);

        return new DosenResource(DosenRepository::createDosen($data));
    }

    public static function updateDosen($id, $data)
    {
        return new DosenResource(DosenRepository::updateDosen($id, $data));
    }

    public static function deleteDosen($id)
    {
        return new DosenResource(DosenRepository::deleteDosen($id));
    }
}
