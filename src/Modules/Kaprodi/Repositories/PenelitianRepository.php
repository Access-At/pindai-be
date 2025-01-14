<?php

namespace Modules\Kaprodi\Repositories;

use App\Enums\StatusPenelitian;
use App\Models\Penelitian;
use App\Models\Prodi;
use App\Models\User;
use Modules\Auth\Resources\AuthResource;
use Modules\Kaprodi\DataTransferObjects\PenelitianDto;
use Modules\Kaprodi\Exceptions\PenelitianException;

class PenelitianRepository
{
    public static function getAllPenelitian()
    {
        $user = auth('api')->user();

        $userLogin = User::where('id', $user->id)
            ->with('kaprodi.faculty')
            ->first();

        $prodi = Prodi::where('faculties_id', $userLogin->kaprodi->faculty->id)
            ->get()
            ->pluck('name');

        return Penelitian::ProdiPenelitian(
            $prodi
        );
    }

    public static function getPenelitianById($id)
    {
        return Penelitian::with(['jenisPenelitian', 'jenisIndex', 'detail.anggotaPenelitian'])
            ->byHash($id)
            ->first();
    }

    public static function approvedPenelitian(string $id)
    {
        $penelitian = Penelitian::byHash($id);

        if (
            $penelitian->status_kaprodi->value === StatusPenelitian::Approval->value ||
            $penelitian->status_kaprodi->value === StatusPenelitian::Reject->value
        ) throw PenelitianException::penelitianCantApproved($penelitian->status_kaprodi->name);

        $penelitian->update([
            'status_kaprodi' => StatusPenelitian::Approval
        ]);

        return self::getPenelitianById($id);
    }

    public static function canceledPenelitian(string $id)
    {
        $penelitian = Penelitian::byHash($id);

        if (
            $penelitian->status_kaprodi->value === StatusPenelitian::Approval->value ||
            $penelitian->status_kaprodi->value === StatusPenelitian::Reject->value
        ) throw PenelitianException::penelitianCantCanceled($penelitian->status_kaprodi->name);

        $penelitian->update([
            'status_kaprodi' => StatusPenelitian::Reject,
            'status_dppm' => StatusPenelitian::Reject,
            'status_keuangan' => StatusPenelitian::Reject
        ]);

        return self::getPenelitianById($id);
    }

    // public static function insertPenelitian(PenelitianDto $data)
    // {
    //     $user = User::create([
    //         'name' => $data->name,
    //         'email' => $data->email,
    //         'address' => $data->address,
    //         'nidn' => $data->nidn,
    //         'password' => $data->password,
    //     ]);
    //     $user->assignRole('Penelitian');

    //     $prodi = Prodi::byHash($data->prodi_id);

    //     return Penelitian::create([
    //         'user_id' => $user->id,
    //         'prodi_id' => $prodi->id,
    //     ]);
    // }

    // public static function updatePenelitian($id, PenelitianDto $data)
    // {
    //     $user = User::byHash($id);

    //     $user->update([
    //         'name' => $data->name ?? $user->name,
    //         'email' => $data->email ?? $user->email,
    //         'address' => $data->address ?? $user->address,
    //         'nidn' => $data->nidn ?? $user->nidn,
    //     ]);

    //     return $user->Penelitian->update([
    //         'prodi_id' => $data->prodi_id ? Prodi::byHash($data->prodi_id)->id : $user->Penelitian->prodi_id,
    //         'name_with_title' => $data->name_with_title ?? $user->Penelitian->name_with_title,
    //         'phone_number' => $data->phone_number ?? $user->Penelitian->phone_number,
    //         'affiliate_campus' => $data->affiliate_campus ?? $user->Penelitian->affiliate_campus,
    //         'job_functional' => $data->job_functional ?? $user->Penelitian->job_functional,
    //         'scholar_id' => $data->scholar_id ?? $user->Penelitian->scholar_id,
    //         'scopus_id' => $data->scopus_id ?? $user->Penelitian->scopus_id,
    //     ]);
    // }

    // public static function deletePenelitian($id)
    // {
    //     $user = User::byHash($id);
    //     $Penelitian = Penelitian::where('user_id', $user->id)->first();

    //     if ($Penelitian) {
    //         $Penelitian->delete();
    //         $user->delete();
    //     }

    //     return $Penelitian;
    // }

    // public static function approvedPenelitian($id)
    // {
    //     $user = User::byHash($id);
    //     return $user->Penelitian->update(['is_approved' => true]);
    // }

    // public static function activePenelitian($id, $active)
    // {
    //     $user = User::byHash($id);
    //     return $user->Penelitian->update(['is_active' => $active]);
    // }
}
