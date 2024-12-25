<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Repositories\KaprodiRepository;
use App\Http\Resources\Dppm\KaprodiResource;
use App\Http\Resources\Pagination\KaprodiPaginationCollection;

class KaprodiService
{
    public static function getAllKaprodi($perPage, $page, $search)
    {
        $data = KaprodiRepository::getAllKaprodi($perPage, $page, $search);

        return new KaprodiPaginationCollection($data);
    }

    public static function getKaprodiById($id)
    {
        return new KaprodiResource(KaprodiRepository::getKaprodiById($id));
    }

    public static function createKaprodi($data)
    {
        $password = Str::random(8);

        // Kirim email dengan password
        Mail::to($data['email'])->queue(new \App\Mail\SendEmail([
            'view' => 'emails.Register',
            'subject' => 'Password Akun Kaprodi',
            'menuju' => 'Kaprodi',
            'oleh' => 'DPPM',
            'data' => [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $password,
            ],
        ]));

        $data['password'] = bcrypt($password);

        return new KaprodiResource(KaprodiRepository::createKaprodi($data));
    }

    public static function updateKaprodi($id, $data)
    {
        return new KaprodiResource(KaprodiRepository::updateKaprodi($id, $data));
    }

    public static function deleteKaprodi($id)
    {
        return new KaprodiResource(KaprodiRepository::deleteKaprodi($id));
    }
}
