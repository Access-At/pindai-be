<?php

namespace Modules\Kaprodi\Services;

use App\Helper\PaginateHelper;
use Modules\Kaprodi\DataTransferObjects\DosenDto;
use Modules\Kaprodi\Exceptions\DosenException;
use Modules\Kaprodi\Interfaces\DosenServiceInterface;
use Modules\Kaprodi\Repositories\DosenRepository;
use Modules\Kaprodi\Resources\DosenResource;
use Modules\Kaprodi\Resources\Pagination\DosenPaginationCollection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class DosenService implements DosenServiceInterface
{
    public function getAllDosen(array $options)
    {
        $data = PaginateHelper::paginate(
            DosenRepository::getAllDosen(),
            $options,
        );
        return new DosenPaginationCollection($data);
    }

    public function getDosenById(string $id)
    {
        $this->validateDosenExists($id);
        return new DosenResource(DosenRepository::getDosenById($id));
    }

    public function insertDosen(DosenDto $request)
    {
        $password = Str::random(8);

        // Kirim email dengan password
        Mail::to($request->email)->queue(new \App\Mail\SendEmail([
            'view' => 'emails.Register',
            'subject' => 'Password Akun Dosen',
            'menuju' => 'Dosen',
            'oleh' => 'Kaprodi',
            'data' => [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password,
            ],
        ]));

        $request->password = bcrypt($password);

        return new DosenResource(DosenRepository::insertDosen($request));
    }

    public function updateDosen(string $id, DosenDto $request)
    {
        $this->validateDosenExists($id);
        return new DosenResource(DosenRepository::updateDosen($id, $request));
    }

    public function deleteDosen(string $id)
    {
        $this->validateDosenExists($id);
        return new DosenResource(DosenRepository::deleteDosen($id));
    }

    public function approvedDosen(string $id)
    {
        $this->validateDosenExists($id);
        return new DosenResource(DosenRepository::approvedDosen($id));
    }

    public function activeDosen(string $id, bool $active)
    {
        $this->validateDosenExists($id);
        return new DosenResource(DosenRepository::activeDosen($id, $active));
    }

    private function validateDosenExists(string $id): void
    {
        $dosen = DosenRepository::getDosenById($id);

        if (!$dosen) {
            throw DosenException::dosenNotFound();
        }
    }
}
