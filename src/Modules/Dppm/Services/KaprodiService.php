<?php

namespace Modules\Dppm\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Modules\Dppm\DataTransferObjects\KaprodiDto;
use Modules\Dppm\Exceptions\FakultasException;
use Modules\Dppm\Exceptions\KaprodiException;
use Modules\Dppm\Interfaces\KaprodiServiceInterface;
use Modules\Dppm\Repositories\FakultasRepository;
use Modules\Dppm\Repositories\KaprodiRepository;
use Modules\Dppm\Resources\KaprodiResource;
use Modules\Dppm\Resources\Pagination\KaprodiPaginationCollection;

class KaprodiService implements KaprodiServiceInterface
{
    public function getAllKaprodi(int $perPage, int $page, string $search)
    {
        return new KaprodiPaginationCollection(KaprodiRepository::getAllKaprodi($perPage, $page, $search));
    }

    public function getKaprodiById(string $id)
    {
        $data = KaprodiRepository::getKaprodiById($id);
        $this->validateKaprodiExists($id);

        return new KaprodiResource($data);
    }

    public function insertKaprodi(KaprodiDto $requst)
    {
        if (FakultasRepository::getFakultasById($requst->fakultas_id)) {
            throw FakultasException::fakultasNotFound();
        }

        $password = Str::random(8);

        Mail::to($requst->email)->queue(new \App\Mail\SendEmail([
            'view' => 'emails.Register',
            'subject' => 'Password Akun Kaprodi',
            'menuju' => 'Kaprodi',
            'oleh' => 'DPPM',
            'data' => [
                'name' => $requst->name,
                'email' => $requst->email,
                'password' => $password,
            ],
        ]));

        $requst->password = bcrypt($password);

        return new KaprodiResource(KaprodiRepository::insertKaprodi($requst));
    }

    public function updateKaprodi(string $id, KaprodiDto $request)
    {
        $this->validateKaprodiExists($id);
        return new KaprodiResource(KaprodiRepository::updateKaprodi($id, $request));
    }

    public function deleteKaprodi(string $id)
    {
        $this->validateKaprodiExists($id);
        return new KaprodiResource(KaprodiRepository::deleteKaprodi($id));
    }

    private function validateKaprodiExists(string $id): void
    {
        $kaprodi = KaprodiRepository::getKaprodiById($id);

        if (!$kaprodi) {
            throw KaprodiException::kaprodiNotFound();
        }
    }
}
