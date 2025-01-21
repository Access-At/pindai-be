<?php

namespace Modules\Keuangan\Repositories;

use App\Models\User;
use App\Models\Faculty;
use App\Models\Kaprodi;
use Modules\Keuangan\DataTransferObjects\KaprodiDto;

class KaprodiRepository
{
    public static function getAllKaprodi()
    {
        return User::kaprodiRole();
    }

    public static function getKaprodiById(string $id)
    {
        return User::kaprodiRole()
            ->with(['kaprodi' => function ($query) {
                $query->with('faculty');
            }])
            ->byHash($id)
            ->first();
    }

    public static function insertKaprodi(KaprodiDto $data)
    {
        $user = User::create([
            'name' => $data->name,
            'email' => $data->email,
            'address' => $data->address,
            'nidn' => $data->nidn,
            'password' => $data->password,
        ]);
        $user->assignRole('kaprodi');

        $faculty = Faculty::byHash($data->fakultas_id);

        return Kaprodi::create([
            'user_id' => $user->id,
            'faculties_id' => $faculty->id,
            'is_active' => $data->status,
        ]);
    }

    public static function updateKaprodi(string $id, KaprodiDto $data)
    {
        $user = User::byHash($id);
        $user->update([
            'name' => $data->name,
            'email' => $data->email,
            'address' => $data->address,
            'nidn' => $data->nidn,
        ]);

        return $user->kaprodi->update([
            'faculties_id' => Faculty::byHash($data->fakultas_id)->id,
            'is_active' => $data->status,
        ]);
    }

    public static function deleteKaprodi(string $id)
    {
        $user = User::byHash($id);
        $kaprodi = Kaprodi::where('user_id', $user->id)->first();

        if ($kaprodi) {
            $kaprodi->delete();
            $user->delete();
        }

        return $kaprodi;
    }
}
