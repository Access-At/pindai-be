<?php

namespace Modules\Keuangan\Services;

use Illuminate\Support\Str;
use App\Helper\PaginateHelper;
use Illuminate\Support\Facades\Mail;
use Modules\Keuangan\Resources\KaprodiResource;
use Modules\Keuangan\Exceptions\KaprodiException;
use Modules\Keuangan\Exceptions\FakultasException;
use Modules\Keuangan\DataTransferObjects\KaprodiDto;
use Modules\Keuangan\Repositories\KaprodiRepository;
use Modules\Keuangan\Repositories\FakultasRepository;
use Modules\Keuangan\Interfaces\KaprodiServiceInterface;
use Modules\Keuangan\Resources\Pagination\KaprodiPaginationCollection;

class KaprodiService implements KaprodiServiceInterface
{
    public function getAllKaprodi(array $options)
    {
        $data = PaginateHelper::paginate(
            KaprodiRepository::getAllKaprodi(),
            $options,
        );

        return new KaprodiPaginationCollection($data);
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

        if ( ! $kaprodi) {
            throw KaprodiException::kaprodiNotFound();
        }
    }
}
